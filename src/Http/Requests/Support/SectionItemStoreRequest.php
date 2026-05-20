<?php

namespace Otas\DynamicPages\Http\Requests\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Otas\DynamicPages\Rules\UniqueForLocaleWithinParent;
use Otas\DynamicPages\Models\SectionItem;

class SectionItemStoreRequest extends FormRequest
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
            'identifier' => 'required|string|regex:/^[a-z0-9-_]+$/|min:3|max:50|unique:section_items,identifier',
            'name' => [
                'required',
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->section,
                    relationName: 'sectionItems',
                    translationForeignKeyName: 'section_item_id',
                    modelClass: 'SectionItem'
                ),
            ],
            'title' => array_merge([
                Rule::requiredIf($this->section->has_items_title),
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_title) {
                        return $fail(__('otas/dynamic_pages/section_items.errors.title_not_available'));
                    }
                }
            ], explode('|', $this->title_validation_text)),

            'description' => array_merge([
                Rule::requiredIf($this->section->has_items_description),
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_description) {
                        return $fail(__('otas/dynamic_pages/section_items.errors.description_not_available'));
                    }
                }
            ], explode('|', $this->description_validation_text)),

            'title_validation_text' => [
                Rule::requiredIf($this->section->has_items_title),
                'string',
                'min:3',
                'max:190'
            ],

            'description_validation_text' => [
                Rule::requiredIf($this->section->has_items_description),
                'string',
                'min:3',
                'max:190',
            ],
        ];
    }

    public function sectionItemStore(): SectionItem
    {
        return DB::transaction(function () {
            $sectionItem = $this->section->sectionItems()->create([
                'identifier' => $this->identifier,
                'title_validation_text' => $this->title_validation_text,
                'description_validation_text' => $this->description_validation_text,
            ]);

            return $sectionItem->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('otas/dynamic_pages/section_items.attributes.name'),
            'title' => __('otas/dynamic_pages/section_items.attributes.title'),
            'description' => __('otas/dynamic_pages/section_items.attributes.description'),
        ];
    }
}
