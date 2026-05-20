<?php

namespace Otas\DynamicPages\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Otas\DynamicPages\Models\Page;

class PageKeywordStoreRequest extends FormRequest
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
            'keywords' => 'nullable|array|min:0|max:20',
            'keywords.*' => 'integer|exists:keywords,id',
        ];
    }

    /**
     * Attach the keyword to the page.
     */
    public function syncKeywords(): Page
    {
        return DB::transaction(function () {
            $this->page->keywords()->sync($this->keywords);

            return $this->page->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'keywords' => __('otas/dynamic_pages/keywords.attributes.keywords'),
            'keywords.*' => __('otas/dynamic_pages/keywords.attributes.keyword'),
        ];
    }
}
