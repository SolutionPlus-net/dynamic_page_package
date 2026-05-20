<?php

namespace Otas\DynamicPages\Http\Requests\Admin;

use Otas\DynamicPages\Models\Keyword;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class KeywordStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'visible' => 'required|boolean',
        ];
    }

    protected function getValidatorInstance()
    {
        $this->merge(format_json_strings_to_boolean(['visible']));
        return parent::getValidatorInstance();
    }

    public function storeKeyword(): Keyword
    {
        return DB::transaction(function () {
            return Keyword::create([
                'is_visible' => $this->visible,
            ])->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('otas/dynamic_pages/keywords.attributes.name'),
            'visible' => __('otas/dynamic_pages/keywords.attributes.visible'),
        ];
    }
}
