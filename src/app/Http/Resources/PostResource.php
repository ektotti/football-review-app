<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = [];
        if(env('APP_ENV') === 'local'){
            $this->image1 ? array_push($images, Storage::disk('public')->url($this->image1)): null; 
            $this->image2 ? array_push($images, Storage::disk('public')->url($this->image2)): null; 
            $this->image3 ? array_push($images, Storage::disk('public')->url($this->image3)): null; 
            $this->image4 ? array_push($images, Storage::disk('public')->url($this->image4)): null;
        } else {
            $this->image1 ? array_push($images, Storage::disk('s3')->url($this->image1)): null; 
            $this->image2 ? array_push($images, Storage::disk('s3')->url($this->image2)): null; 
            $this->image3 ? array_push($images, Storage::disk('s3')->url($this->image3)): null; 
            $this->image4 ? array_push($images, Storage::disk('s3')->url($this->image4)): null;
        }
        return [
            "data"=>[
                "id"=> $this->id,
                "user_id"=> $this->user_id,
                "fixture_id"=> $this->fixture_id,
                "title"=> $this->title,
                "images"=>$images,
                "body"=> $this->body,
                "user"=> $this->user,
                "fixture"=> $this->fixture,
                "comments"=> $this->comments,
                "likes"=> $this->likes,
            ],
            "first_page_url"=> "http://localhost/post-list?page=1",
            "from"=> 4,
            "next_page_url"=> "http://localhost/post-list?page=3",
            "path"=> "http://localhost/post-list",
            "per_page"=> 3,
            "prev_page_url"=> "http://localhost/post-list?page=1",
            "to"=> 6,
            "hasMorePage"=> true
        ];
    }
}
