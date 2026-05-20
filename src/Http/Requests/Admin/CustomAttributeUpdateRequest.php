<?php

namespace Otas\DynamicPages\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Mabrouk\Translatable\Rules\RequiredForLocale;
use Otas\DynamicPages\Rules\UniqueForLocaleWithinParent;
use Otas\DynamicPages\Models\CustomAttribute;

class CustomAttributeUpdateRequest extends FormRequest
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
            'name' => [
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->section_item ?: $this->section,
                    relationName: 'customAttributes',
                    translationForeignKeyName: 'custom_attribute_id',
                    modelObject: $this->custom_attribute,
                ),
                new RequiredForLocale($this->custom_attribute),
            ],

            'value' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->custom_attribute->value_validation_text) {
                        return $fail(__('otas/dynamic_pages/custom_attributes.errors.value_not_allowed'));
                    }
                }
            ], explode('|', $this->custom_attribute->value_validation_text)),
        ];
    }

    /**
     * Update the custom attribute with the validated data.
     */
    public function updateCustomAttribute(): CustomAttribute
    {
        return DB::transaction(function () {
            $this->custom_attribute->update();

            return $this->custom_attribute->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('otas/dynamic_pages/custom_attributes.attributes.name'),
            'value' => __('otas/dynamic_pages/custom_attributes.attributes.value'),
        ];
    }
}
