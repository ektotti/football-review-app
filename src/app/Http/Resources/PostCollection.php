<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
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
            if (env('APP_ENV') === 'local') {
               $post->image1 = $post->image1 ? Storage::disk('public')->url($post->image1) : null;
               $post->image2 = $post->image2 ? Storage::disk('public')->url($post->image2) : null;
               $post->image3 = $post->image3 ? Storage::disk('public')->url($post->image3) : null;
               $post->image4 = $post->image4 ? Storage::disk('public')->url($post->image4) : null;
            } else {
                $post->image1 = $post->image1 ? Storage::disk('s3')->url($post->image1) : null;
                $post->image2 = $post->image2 ? Storage::disk('s3')->url($post->image2) : null;
                $post->image3 = $post->image3 ? Storage::disk('s3')->url($post->image3) : null;
                $post->image4 = $post->image4 ? Storage::disk('s3')->url($post->image4) : null;
            }

            return [
                "id" => $post->id,
                "user_id" => $post->user_id,
                "fixture_id" => $post->fixture_id,
                "title" => $post->title,
                "image1" => $post->image1,
                "image2" => $post->image2,
                "image3" => $post->image3,
                "image4" => $post->image4,
                "body" => $post->body,
                "user" => $post->user,
                "fixture" => $post->fixture,
                "comments" => $post->comments,
                "likes" => $post->likes,
            ];
        });
        return $this->collection;
    }
}
