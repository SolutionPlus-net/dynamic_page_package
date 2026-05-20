<?php

namespace Otas\DynamicPages\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomAttributeResource extends JsonResource
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

            'key' => $this->key,
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
