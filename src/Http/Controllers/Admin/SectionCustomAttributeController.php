<?php

namespace Otas\DynamicPages\Http\Controllers\Admin;

use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Models\CustomAttribute;
use Otas\DynamicPages\Filters\Admin\CustomAttributeFilter;
use Otas\DynamicPages\Http\Resources\Admin\CustomAttributeResource;
use Otas\DynamicPages\Http\Requests\Admin\CustomAttributeUpdateRequest;

class SectionCustomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, CustomAttributeFilter $filters)
    {
        $paginationLength = pagination_length(CustomAttribute::class);
        $customAttributes = $section->customAttributes()->filter($filters)->paginate($paginationLength);

        return CustomAttributeResource::collection($customAttributes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, CustomAttribute $custom_attribute)
    {
        return response([
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomAttributeUpdateRequest $request, Page $page, Section $section, CustomAttribute $custom_attribute)
    {
        $request->updateCustomAttribute();

        return response([
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
            'message' => __('otas/dynamic_pages/custom_attributes.update'),
        ]);
    }
}
