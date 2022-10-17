<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Post;
use App\Tag;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Service\ImageService;
use App\Service\PostService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request, ImageService $imageService, PostService $postService)
    {
        try {
            DB::beginTransaction();
            $imageStoragePath = 'posts/';
            $imagePath = $imageService->saveImagesAndGetImagePath($imageStoragePath, $request->images);

            $fixtureId = $request->session()->get('fixture_id');
            $postId = $postService->storePost($request, $fixtureId, $imagePath);
            $postService->storeTagsAndRelateToPost($request->textContent, $postId);

            DB::commit();
        } catch (Exeption $e) {
            DB::rollBack();
            $imageService->deleteFromStorage($imagePath);
            Log::debug($e->getMessage);
            return json_decode($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with(['user', 'fixture', 'comments.user', 'likes'])->get()->find($id);
        $isSelf = $post->checkIsSelf();
        $likeThisPost = $post->checkUserLikePost();

        return view('post_detail', compact('post', 'likeThisPost', 'isSelf'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $selectedPost = Post::where('id', $id)->first();
            $selectedPost->body = $request->body;
            $selectedPost->title = $request->title;
            $selectedPost->save();

            $tagIds = Tag::saveTagsAndGetIdsFromText($request->body);
            if ($tagIds) {
                $selectedPost->tags()->sync($tagIds);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            report($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            $result = Post::destroy($id);
            if (!$result) {
                throw new Exception('何かがおかしいようです。投稿が削除できませんでした。');
            }

            $imagePath = [];
            for ($i = 1; $i <= 4; $i++) {
                if ($post["image$i"]) {
                    $image = str_replace(env('AWS_BUCKET_URL'), '', $post["image$i"]);
                    array_push($imagePath, $image);
                }
            }
            $result = Storage::disk('s3')->delete($imagePath);
            if (!$result) {
                throw new Exception('何かがおかしいようです。画像を削除できませんでした。');
            }
            
            DB::commit();
            return redirect('/');
        } catch (Exception $e) {
            DB::rollBack();
            echo "エラー" . $e->getMessage();
        }
    }
}
