<?php

namespace Otas\DynamicPages\Http\Requests\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Otas\DynamicPages\Models\Section;

class SectionMediaStoreRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ];
    }

    public function storeSectionMedia(): Section
    {
        return DB::transaction(function () {
            $this->addImage();

            return $this->section->refresh();
        });
    }

    protected function addImage(): self
    {
        $this->section->addMedia(
            type: 'photo',
            path: $this->image->storeAs(
                $this->section->photosDirectory,
                Str::slug($this->section->identifier . random_by(), '_') . '.' . $this->image->getClientOriginalExtension()
            ),
            title: 'section_image'
        );

        return $this;
    }

    public function attributes(): array
    {
        return [
            'image' => __('otas/dynamic_pages/sections.attributes.image'),
        ];
    }
}
