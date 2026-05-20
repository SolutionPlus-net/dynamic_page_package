<?php

namespace Otas\DynamicPages\Http\Controllers\Support;

use Otas\DynamicPages\Filters\Support\PageFilter;
use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Requests\Support\PageStoreRequest;
use Otas\DynamicPages\Http\Requests\Support\PageUpdateRequest;
use Otas\DynamicPages\Http\Resources\Support\PageResource;
use Otas\DynamicPages\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageFilter $filter)
    {
        $paginationLength = pagination_length(Page::class);
        $pages = Page::filter($filter)->with('translations')->paginate($paginationLength);

        return PageResource::collection($pages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $page = $request->storePage();

        return response([
            'page' => new PageResource($page),
            'message' => __('otas/dynamic_pages/pages.store'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return response([
            'page' => new PageResource($page),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request, Page $page)
    {
        $page = $request->updatePage();

        return response([
            'page' => new PageResource($page),
            'message' => __('otas/dynamic_pages/pages.update'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        if ($page->remove()) {
            return response([
                'message' => __('otas/dynamic_pages/pages.destroy'),
            ]);
        }

        return response([
            'message' => __('otas/dynamic_pages/pages.cant_destroy'),
        ], 409);
    }
}
