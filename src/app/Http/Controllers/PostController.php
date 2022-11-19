<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Tag;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
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
            $insertedPost = $postService->storePost($request, $fixtureId, $imagePath);
            $postService->storeTagsAndRelateToPost($insertedPost);

            DB::commit();
        } catch (Exeption $e) {
            DB::rollBack();
            $imageService->deleteFromStorage($imagePath);
            return json_decode($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, PostService $postService)
    {
        $post = new PostResource($postService->getById($id));
        return view('post_detail', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, PostService $postService, $id)
    {
        try {
            DB::beginTransaction();
            $editedPost = $postService->updatePost($request, $id);
            $postService->storeTagsAndRelateToPost($editedPost);
            $tagIds = Tag::saveTagsAndGetIdsFromText($request->body);
            if ($tagIds) {
                $editedPost->tags()->sync($tagIds);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug("アップデートできません");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PostService $postService, ImageService $imageService)
    {
        DB::beginTransaction();
        try {
            $post = $postService->getById($id);
            $postService->delete($id);

            $imagePath = [];
            for ($i = 1; $i <= 4; $i++) {
                if ($post["image$i"]) {
                    $image = str_replace(env('AWS_BUCKET_URL'), '', $post["image$i"]);
                    array_push($imagePath, $image);
                }
            }
            $imageService->deleteFromStorage($imagePath);                        
            DB::commit();
            return redirect('/');
        } catch (Exception $e) {
            DB::rollBack();
            echo "エラー" . $e->getMessage();
        }
    }
}
