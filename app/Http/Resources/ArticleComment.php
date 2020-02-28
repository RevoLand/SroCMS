<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleComment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_id' => $this->article_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->getName(),
            'user_avatar' => $this->user->gravatar,
            'content' => $this->content,
            'approved' => $this->is_approved,
            'visible' => $this->is_visible,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(),
            'updated_at' => $this->updated_at,
        ];
    }
}
