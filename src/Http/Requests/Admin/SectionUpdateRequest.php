<?php

namespace Otas\DynamicPages\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Otas\Translatable\Rules\RequiredForLocale;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Rules\UniqueForLocaleWithinParent;

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
                    parentObject: $this->page,
                    relationName: 'sections',
                    translationForeignKeyName: 'section_id',
                    modelObject: $this->section,
                ),
                new RequiredForLocale($this->section),
            ],
            'title' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_title) {
                        return $fail(__('otas/dynamic_pages/sections.errors.title_not_available'));
                    }
                }
            ], explode('|', $this->section->title_validation_text)),
            'description' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_description) {
                        return $fail(__('otas/dynamic_pages/sections.errors.description_not_available'));
                    }
                }
            ], explode('|', $this->section->description_validation_text)),
        ];
    }

    /**
     * Update the section with the validated data.
     */
    public function updateSection(): Section
    {
        return DB::transaction(function () {
            $this->section->update();

            return $this->section->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('otas/dynamic_pages/sections.attributes.name'),
            'title' => __('otas/dynamic_pages/sections.attributes.title'),
            'description' => __('otas/dynamic_pages/sections.attributes.description'),
        ];
    }
}
