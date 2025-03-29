<?php

namespace App\Http\Resources;

use App\Models\Like;
use Carbon\Carbon;
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
        Carbon::setLocale('fr');
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "content"=> $this->content,
            "imageUrl"=> $this->imageUrl,
            "author"=> $this->user,
            "date" => Carbon::parse($this->created_at)->diffForHumans(),
            "likes" => $this->likes->count(),

            //relations avec with categories, comments et tags
            "nbr_comments"=> CommentResource::collection($this->comments)->count(),
            //"comments"=> CommentResource::collection($this->comments),
            "tags" => TagResource::collection($this->tags),
            "categories"=> CategoryResource::collection($this->categories),
        ];
    }
}
