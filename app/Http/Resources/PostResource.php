<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "content"=> $this->content,
            "imageUrl"=> $this->imageUrl,
            "user_id"=>$this->user_id,
            "user_name"=>$this->user_name,
            "date" =>$this->created_at,

            //relations avec with
            "Comments"=> CommentResource::collection($this->comments),
            "Categories"=> $this->categories,
        ];  
    }
}
