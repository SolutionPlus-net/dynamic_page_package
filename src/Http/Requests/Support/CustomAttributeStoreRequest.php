<?php

namespace Otas\DynamicPages\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Otas\DynamicPages\Models\CustomAttribute;
use Otas\DynamicPages\Rules\UniqueForLocaleWithinParent;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Models\SectionItem;

class CustomAttributeStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'key' => 'required|string|regex:/^[a-z0-9-_]+$/|min:3|max:50|unique:custom_attributes,key',
            'name' => [
                'required',
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->section_item ?: $this->section,
                    relationName: 'customAttributes',
                    translationForeignKeyName: 'custom_attribute_id',
                    modelClass: 'CustomAttribute'
                ),
            ],
            'value' => array_merge([
                'required_with:value_validation_text',
            ], explode('|', $this->value_validation_text)),

            'value_validation_text' => 'nullable|required_with:value|string|min:3|max:190',
        ];
    }

    public function storeCustomAttribute(Section|SectionItem $relatedObject): CustomAttribute
    {
        return DB::transaction(function () use ($relatedObject) {
            return $relatedObject->customAttributes()->create([
                'key' => $this->key,
                'value_validation_text' => $this->value_validation_text,
            ])->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'key' => __('otas/dynamic_pages/custom_attributes.attributes.key'),
            'name' => __('otas/dynamic_pages/custom_attributes.attributes.name'),
            'value' => __('otas/dynamic_pages/custom_attributes.attributes.value'),
            'value_validation_text' => __('otas/dynamic_pages/custom_attributes.attributes.value_validation_text'),
        ];
    }
}
