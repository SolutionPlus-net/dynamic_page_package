<?php

namespace Otas\DynamicPages\Http\Controllers\Admin;

use Otas\DynamicPages\Filters\Admin\KeywordFilter;
use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Models\Keyword;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Http\Requests\Admin\PageKeywordStoreRequest;
use Otas\DynamicPages\Http\Resources\Admin\KeywordResource;
use Otas\DynamicPages\Http\Resources\Admin\PageResource;

class PageKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, KeywordFilter $filters)
    {
        $paginationLength = pagination_length(Keyword::class);
        $keywords = $page->keywords()->filter($filters)->paginate($paginationLength);

        return KeywordResource::collection($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageKeywordStoreRequest $request, Page $page)
    {
        $page = $request->syncKeywords();

        return response([
            'message' => __('otas/dynamic_pages/pages.update'),
            'page' => new PageResource($page),
        ]);
    }
}
