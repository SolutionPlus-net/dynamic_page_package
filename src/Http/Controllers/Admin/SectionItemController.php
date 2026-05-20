<?php

namespace Otas\DynamicPages\Http\Controllers\Admin;

use Otas\DynamicPages\Filters\Admin\SectionItemFilter;
use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Requests\Admin\SectionItemUpdateRequest;
use Otas\DynamicPages\Http\Resources\Admin\SectionItemResource;
use Otas\DynamicPages\Http\Resources\Admin\SectionItemSimpleResource;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Models\SectionItem;

class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItemFilter $filters)
    {
        $paginationLength = pagination_length(SectionItem::class);
        $sectionItems = $section->sectionItems()->filter($filters)->with('translations')->paginate($paginationLength);

        return SectionItemSimpleResource::collection($sectionItems);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item)
    {
        $section_item->load([
            'section.translations',
            'media',
            'customAttributes.translations'
        ]);

        return response([
            'section_item' => new SectionItemResource($section_item),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionItemUpdateRequest $request, Page $page, Section $section, SectionItem $section_item)
    {
        $request->sectionItemUpdate();

        return response([
            'message' => __('otas/dynamic_pages/section_items.update'),
            'section_item' => new SectionItemResource($section_item),
        ]);
    }
}
