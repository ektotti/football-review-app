<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Tag;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Service\ImageService;
use App\Service\PostService;
use App\Service\TagService;
use Exception;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    public $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
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
    public function store(PostStoreRequest $request, ImageService $imageService, TagService $tagService)
    {
        try {
            DB::beginTransaction();
            $imageStoragePath = 'posts/';
            $imagePath = $imageService->saveImagesAndGetImagePath($imageStoragePath, $request->images);

            $fixtureId = $request->session()->get('fixture_id');
            $insertedPost = $this->postService->storePost($request, $fixtureId, $imagePath);
            $tagIds = $tagService->storeTags($insertedPost);
            $insertedPost->tags()->sync($tagIds);

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
    public function show($id)
    {
        $post = new PostResource($this->postService->getById($id));
        return view('post_detail', compact('post'));
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
            $editedPost = $this->postService->updatePost($request, $id);
            $this->postService->storeTagsAndRelateToPost($editedPost);
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
    public function destroy($id, ImageService $imageService)
    {
        DB::beginTransaction();
        try {
            $post = $this->postService->getById($id);
            $this->postService->delete($id);

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
