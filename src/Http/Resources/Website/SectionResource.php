<?php

namespace Otas\DynamicPages\Http\Resources\Website;

use Illuminate\Http\Resources\Json\JsonResource;
use Mabrouk\Mediable\Http\Resources\MediaResource;

class SectionResource extends JsonResource
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

            'images' => MediaResource::collection($this->images),
            'items' => SectionItemResource::collection($this->sectionItems),
            'custom_attributes' => CustomAttributeResource::collection($this->customAttributes),
        ];
    }
}
