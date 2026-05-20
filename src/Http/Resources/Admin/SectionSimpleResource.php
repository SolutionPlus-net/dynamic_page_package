<?php

namespace Otas\DynamicPages\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Mabrouk\Mediable\Http\Resources\MediaResource;

class SectionSimpleResource extends JsonResource
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

            'identifier' => $this->identifier,

            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,

            'has_title' => $this->has_title,
            'has_description' => $this->has_description,
            'images_count' => $this->images_count,

            'has_items' => $this->has_items,
            'item_images_count' => $this->item_images_count,
            'has_items_title' => $this->has_items_title,
            'has_items_description' => $this->has_items_description,
            'has_custom_attributes' => $this->hasCustomAttributes,
        ];
    }
}
