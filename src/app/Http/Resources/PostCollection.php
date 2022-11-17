<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collectResource($this->collection)->transform(function ($post) {
            $images = [];
            if (env('APP_ENV') === 'local') {
                $post->image1 = $post->image1 ? array_push($images, Storage::disk('public')->url($post->image1)) : null;
                $post->image2 = $post->image2 ? array_push($images, Storage::disk('public')->url($post->image2)) : null;
                $post->image3 = $post->image3 ? array_push($images, Storage::disk('public')->url($post->image3)) : null;
                $post->image4 = $post->image4 ? array_push($images, Storage::disk('public')->url($post->image4)) : null;
            } else {
                $post->image1 = $post->image1 ? array_push($images, Storage::disk('s3')->url($post->image1)) : null;
                $post->image2 = $post->image2 ? array_push($images, Storage::disk('s3')->url($post->image2)) : null;
                $post->image3 = $post->image3 ? array_push($images, Storage::disk('s3')->url($post->image3)) : null;
                $post->image4 = $post->image4 ? array_push($images, Storage::disk('s3')->url($post->image4)) : null;
            }

            return [
                "id" => $post->id,
                "user_id" => $post->user_id,
                "fixture_id" => $post->fixture_id,
                "title" => $post->title,
                "images" => $images,
                "body" => $post->body,
                "user" => $post->user,
                "fixture" => $post->fixture,
                "comments" => $post->comments,
                "likes" => $post->likes,
                "isSelf" => $post->checkIsSelf(),
                "likeThisPost" => $post->checkUserLikePost()
            ];
        });
        return $this->collection;
    }
}
