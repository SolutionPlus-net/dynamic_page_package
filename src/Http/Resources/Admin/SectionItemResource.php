<?php

namespace Otas\DynamicPages\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Mabrouk\Mediable\Http\Resources\MediaResource;

class SectionItemResource extends JsonResource
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
            'has_custom_attributes' => $this->hasCustomAttributes,

            'section' => new SectionSimpleResource($this->section),
            'images' => MediaResource::collection($this->images),
            'custom_attributes' => CustomAttributeResource::collection($this->customAttributes),
        ];
    }
}
