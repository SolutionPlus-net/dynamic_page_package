<?php

namespace Otas\DynamicPages\Http\Requests\Support;

use Otas\DynamicPages\Rules\UniqueForLocaleWithinParent;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Otas\DynamicPages\Models\Section;

class SectionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => 'sometimes|string|regex:/^[a-z0-9-_]+$/|min:3|max:50|unique:sections,identifier,' . $this->section->id,
            'name' => [
                'sometimes',
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->page,
                    relationName: 'sections',
                    translationForeignKeyName: 'section_id',
                    modelObject: $this->section,
                ),
            ],
            'images_count' => [
                'sometimes',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    $sectionMedia = $this->section->media;
                    if ($sectionMedia && $sectionMedia->count() > $value) {
                        $fail(__('otas/dynamic_pages/sections.errors.images_exceed_allowed_count'));
                    }
                },
            ],
            'has_items' => [
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($this->section->has_items && $value == 0 && $this->section->sectionItems()->count() > 0) {
                        $fail(__('otas/dynamic_pages/sections.errors.items_already_exists'));
                    }
                },
            ],
            'item_images_count' => [
                'sometimes',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->section->item_images_count != 0 && $value == 0 && $this->section->sectionItems()->count() > 0) {
                        $fail(__('otas/dynamic_pages/sections.errors.items_already_exists'));
                    }
                },
            ],

            'title_validation_text' => 'sometimes|string|min:3|max:190',
            'description_validation_text' => 'sometimes|string|min:3|max:190',
        ];
    }

    protected function getValidatorInstance()
    {
        $this->merge(format_json_strings_to_boolean(['has_items']));
        return parent::getValidatorInstance();
    }

    public function updateSection(): Section
    {
        return DB::transaction(function () {
            $this->section->update([
                'identifier' => $this->exists('identifier') ? $this->identifier : $this->section->identifier,

                'images_count' => $this->exists('images_count') ? $this->input('images_count') : $this->section->images_count,

                'has_items' => $this->exists('has_items') ? $this->is_has_items : $this->section->has_items,
                'item_images_count' => $this->exists('item_images_count') ? $this->input('item_images_count') : $this->section->item_images_count,

                'title_validation_text' => $this->exists('title_validation_text') ? $this->title_validation_text : $this->section->title_validation_text,
                'description_validation_text' => $this->exists('description_validation_text') ? $this->description_validation_text : $this->section->description_validation_text,
            ]);

            return $this->section->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'identifier' => __('otas/dynamic_pages/sections.attributes.identifier'),
            'name' => __('otas/dynamic_pages/sections.attributes.name'),
            'images_count' => __('otas/dynamic_pages/sections.attributes.images_count'),
            'has_items' => __('otas/dynamic_pages/sections.attributes.has_items'),
            'item_images_count' => __('otas/dynamic_pages/sections.attributes.item_images_count'),
            'title_validation_text' => __('otas/dynamic_pages/sections.attributes.title_validation_text'),
            'description_validation_text' => __('otas/dynamic_pages/sections.attributes.description_validation_text'),
        ];
    }
}
