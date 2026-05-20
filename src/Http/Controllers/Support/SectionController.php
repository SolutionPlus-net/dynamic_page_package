<?php

namespace Otas\DynamicPages\Http\Controllers\Support;

use Otas\DynamicPages\Filters\Support\SectionFilter;
use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Requests\Support\SectionStoreRequest;
use Otas\DynamicPages\Http\Requests\Support\SectionUpdateRequest;
use Otas\DynamicPages\Http\Resources\Support\SectionResource;
use Otas\DynamicPages\Http\Resources\Support\SectionSimpleResource;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, SectionFilter $filters)
    {
        $paginationLength = pagination_length(Section::class);
        $sections = $page->sections()->filter($filters)->with('translations')->paginate($paginationLength);

        return SectionSimpleResource::collection($sections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionStoreRequest $request, Page $page)
    {
        $section = $request->storeSection();

        return response([
            'message' => __('otas/dynamic_pages/sections.store'),
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section)
    {
        $section->load([
            'page.translations',
            'media',
            'customAttributes.translations',
            'sectionItems.translations',
            'sectionItems.media',
            'sectionItems.customAttributes.translations'
        ]);

        return response([
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionUpdateRequest $request, Page $page, Section $section)
    {
        $request->updateSection();

        return response([
            'message' => __('otas/dynamic_pages/sections.update'),
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page, Section $section)
    {
        if ($section->remove()) {
            return response([
                'message' => __('otas/dynamic_pages/sections.destroy'),
            ]);
        }

        return response([
            'message' => __('otas/dynamic_pages/sections.cant_destroy'),
        ], 409);
    }
}
