<?php

namespace Otas\DynamicPages\Http\Resources\Support;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'path' => $this->path,

            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
