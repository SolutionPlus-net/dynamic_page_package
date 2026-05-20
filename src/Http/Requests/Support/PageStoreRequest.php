<?php

namespace Otas\DynamicPages\Http\Requests\Support;

use Otas\DynamicPages\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PageStoreRequest extends FormRequest
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
            'path' => 'required|string|regex:/^[a-z0-9-_]+$/|min:3|max:190|unique:pages,path',
            'name' => 'required|string|min:3|max:255',
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:40000',
        ];
    }

    /**
     * Store the page with the validated data.
     */
    public function storePage(): Page
    {
        return DB::transaction(function () {
            $page = Page::create([
                'path' => $this->path,
            ]);

            return $page->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'path' => __('otas/dynamic_pages/pages.attributes.path'),
            'name' => __('otas/dynamic_pages/pages.attributes.name'),
            'title' => __('otas/dynamic_pages/pages.attributes.title'),
            'description' => __('otas/dynamic_pages/pages.attributes.description'),
        ];
    }
}
