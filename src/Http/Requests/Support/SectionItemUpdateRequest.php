<?php

namespace Otas\DynamicPages\Http\Requests\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Mabrouk\Translatable\Rules\RequiredForLocale;
use Otas\DynamicPages\Rules\UniqueForLocaleWithinParent;

class SectionItemUpdateRequest extends FormRequest
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
            'identifier' => 'sometimes|string|regex:/^[a-z0-9-_]+$/|min:3|max:50|unique:section_items,identifier,' . $this->section_item->id,
            'name' => [
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->section,
                    relationName: 'sectionItems',
                    translationForeignKeyName: 'section_item_id',
                    modelObject: $this->section_item,
                ),
                new RequiredForLocale($this->section_item),
            ],

            'title' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_title) {
                        return $fail(__('otas/dynamic_pages/section_items.errors.title_not_available'));
                    }
                }
            ], explode('|', $this->title_validation_text ?? $this->section_item->title_validation_text)),

            'description' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_description) {
                        return $fail(__('otas/dynamic_pages/section_items.errors.description_not_available'));
                    }
                }
            ], explode('|', $this->description_validation_text ?? $this->section_item->description_validation_text)),

            'title_validation_text' => [
                'sometimes',
                'string',
                'min:3',
                'max:190',
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_title) {
                        return $fail(__('otas/dynamic_pages/section_items.errors.title_not_available'));
                    }
                },
            ],

            'description_validation_text' => [
                'sometimes',
                'string',
                'min:3',
                'max:190',
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_description) {
                        return $fail(__('otas/dynamic_pages/section_items.errors.description_not_available'));
                    }
                },
            ],
        ];
    }

    public function sectionItemUpdate()
    {
        return DB::transaction(function () {
            $this->section_item->update([
                'identifier' => $this->exists('identifier') ? $this->identifier : $this->section_item->identifier,
                'title_validation_text' => $this->exists('title_validation_text') ? $this->title_validation_text : $this->section_item->title_validation_text,
                'description_validation_text' => $this->exists('description_validation_text') ? $this->description_validation_text : $this->section_item->description_validation_text,
            ]);

            return $this->section_item->refresh();
        });
    }

    public function attributes()
    {
        return [
            'identifier' => __('otas/dynamic_pages/section_items.attributes.identifier'),
            'name' => __('otas/dynamic_pages/section_items.attributes.name'),
            'title' => __('otas/dynamic_pages/section_items.attributes.title'),
            'description' => __('otas/dynamic_pages/section_items.attributes.description'),
            'title_validation_text' => __('otas/dynamic_pages/section_items.attributes.title_validation_text'),
            'description_validation_text' => __('otas/dynamic_pages/section_items.attributes.description_validation_text'),
        ];
    }
}
