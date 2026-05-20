<?php

namespace Otas\DynamicPages\Http\Controllers\Admin;

use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Requests\Admin\CustomAttributeUpdateRequest;
use Otas\DynamicPages\Http\Resources\Admin\CustomAttributeResource;
use Otas\DynamicPages\Models\CustomAttribute;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Models\SectionItem;

class SectionItemCustomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItem $section_item)
    {
        $paginationLength = pagination_length(CustomAttribute::class);
        $customAttributes = $section_item->customAttributes()->paginate($paginationLength);

        return CustomAttributeResource::collection($customAttributes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item, CustomAttribute $custom_attribute)
    {
        return response([
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomAttributeUpdateRequest $request, Page $page, Section $section, SectionItem $section_item, CustomAttribute $custom_attribute)
    {
        $request->updateCustomAttribute();

        return response([
            'message' => __('otas/dynamic_pages/custom_attributes.update'),
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
        ]);
    }
}
