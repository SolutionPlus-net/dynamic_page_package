<?php

namespace Otas\DynamicPages\Http\Controllers\Admin;

use Otas\DynamicPages\Filters\Admin\KeywordFilter;
use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Models\Keyword;
use Otas\DynamicPages\Http\Requests\Admin\KeywordStoreRequest;
use Otas\DynamicPages\Http\Requests\Admin\KeywordUpdateRequest;
use Otas\DynamicPages\Http\Resources\Admin\KeywordResource;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KeywordFilter $filters)
    {
        $paginationLength = pagination_length(Keyword::class);
        $keywords = Keyword::filter($filters)->paginate($paginationLength);

        return KeywordResource::collection($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KeywordStoreRequest $request)
    {
        $keyword = $request->storeKeyword();

        return response([
            'message' => __('otas/dynamic_pages/keywords.store'),
            'keyword' => new KeywordResource($keyword),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        return response([
            'keyword' => new KeywordResource($keyword),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KeywordUpdateRequest $request, Keyword $keyword)
    {
        $request->updateKeyword();

        return response([
            'message' => __('otas/dynamic_pages/keywords.update'),
            'keyword' => new KeywordResource($keyword),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        if ($keyword->remove()) {
            return response([
                'message' => __('otas/dynamic_pages/keywords.destroy'),
            ]);
        }

        return response([
            'message' => __('otas/dynamic_pages/keywords.cant_destroy'),
        ], 409);
    }
}
