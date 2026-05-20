<?php

namespace Otas\DynamicPages\Http\Controllers\Admin;

use Otas\DynamicPages\Http\Controllers\Controller;
use Otas\DynamicPages\Http\Requests\Admin\SectionMediaStoreRequest;
use Otas\DynamicPages\Models\Section;
use Otas\Mediable\Models\Media;
use Otas\DynamicPages\Http\Resources\Admin\SectionResource;

class SectionMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionMediaStoreRequest $request, Section $section)
    {
        if ($section->images_count <= $section->media()->count()) {
            abort(409, __('otas/dynamic_pages/sections.errors.images_exceed_allowed_count'));
        }

        $request->storeSectionMedia();

        return response([
            'message' => __('otas/dynamic_pages/sections.media.store'),
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, Media $media)
    {
        $section->removeMedia($media);

        return response([
            'message' => __('otas/dynamic_pages/sections.media.destroy'),
        ]);
    }
}
