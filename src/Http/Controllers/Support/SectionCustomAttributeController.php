<?php

namespace Otas\DynamicPages\Http\Controllers\Support;

use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Models\CustomAttribute;
use Otas\DynamicPages\Http\Requests\Support\CustomAttributeUpdateRequest;
use Otas\DynamicPages\Http\Requests\Support\CustomAttributeStoreRequest;
use Otas\DynamicPages\Http\Resources\Support\CustomAttributeResource;

class SectionCustomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section)
    {
        $paginationLength = pagination_length(CustomAttribute::class);
        $customAttributes = $section->customAttributes()->paginate($paginationLength);

        return CustomAttributeResource::collection($customAttributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomAttributeStoreRequest $request, Page $page, Section $section)
    {
        $customAttribute = $request->storeCustomAttribute(relatedObject: $section);

        return response([
            'message' => __('otas/dynamic_pages/custom_attributes.store'),
            'custom_attribute' => new CustomAttributeResource($customAttribute),
        ]);
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
        $customAttribute = $request->updateCustomAttribute();

        return response([
            'message' => __('otas/dynamic_pages/custom_attributes.update'),
            'custom_attribute' => new CustomAttributeResource($customAttribute),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page, Section $section, CustomAttribute $custom_attribute)
    {
        if ($custom_attribute->remove()) {
            return response([
                'message' => __('otas/dynamic_pages/custom_attributes.destroy'),
            ]);
        }

        return response([
            'message' => __('otas/dynamic_pages/custom_attributes.cant_destroy'),
        ], 409);
    }
}
