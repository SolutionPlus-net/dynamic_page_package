<?php

namespace Otas\DynamicPages\Http\Controllers\Support;

use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Requests\Support\SectionItemMediaStoreRequest;
use Otas\DynamicPages\Models\SectionItem;
use Mabrouk\Mediable\Models\Media;
use Otas\DynamicPages\Http\Resources\Support\SectionItemResource;

class SectionItemMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionItemMediaStoreRequest $request, SectionItem $section_item)
    {
        if ($section_item->section->item_images_count <= $section_item->media()->count()) {
            abort(409, __('otas/dynamic_pages/section_items.errors.images_exceed_allowed_count'));
        }

        $request->storeSectionItemMedia();

        return response([
            'message' => __('otas/dynamic_pages/section_items.media.store'),
            'section_item' => new SectionItemResource($section_item),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SectionItem $section_item, Media $media)
    {
        $section_item->removeMedia($media);

        return response([
            'message' => __('otas/dynamic_pages/section_items.media.destroy'),
        ]);
    }
}
