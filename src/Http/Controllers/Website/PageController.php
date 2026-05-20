<?php

namespace Otas\DynamicPages\Http\Controllers\Website;

use Otas\DynamicPages\Filters\Website\PageFilter;
use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Resources\Website\PageResource;
use Otas\DynamicPages\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageFilter $filter)
    {
        $paginationLength = pagination_length(Page::class);
        $pages = Page::filter($filter)->with([
            'translations',
            'sections.translations',
            'sections.media',
            'sections.customAttributes.translations',
            'sections.sectionItems.translations',
            'sections.sectionItems.media',
            'sections.sectionItems.customAttributes.translations',
            'visibleKeywords.translations',
        ])->paginate($paginationLength);

        return PageResource::collection($pages);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load([
            'translations',
            'sections.translations',
            'sections.media',
            'sections.customAttributes.translations',
            'sections.sectionItems.translations',
            'sections.sectionItems.media',
            'sections.sectionItems.customAttributes.translations',
            'visibleKeywords.translations',
        ]);

        return response([
            'page' => new PageResource($page),
        ]);
    }
}
