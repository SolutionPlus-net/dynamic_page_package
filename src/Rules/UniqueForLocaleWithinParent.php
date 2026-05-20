<?php

namespace Otas\DynamicPages\Rules;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueForLocaleWithinParent implements ValidationRule
{
    /**
     * The model instance used to check for existing translations.
     *
     * @param Model $modelObject The model object to validate against.
     */
    public function __construct(
        private Model $parentObject,
        private string $relationName,
        private string $translationForeignKeyName,
        private ?Model $modelObject = null,
        private ?string $modelClass = null
    ) {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $relationName = $this->relationName;

        $relationDataIds = $this->parentObject->$relationName()->pluck('id')->toArray();

        $translationClass = $this->modelObject ? $this->modelObject->translationModelClass : "Otas\\DynamicPages\\Models\\" . $this->modelClass . "Translation";
        $locale = request()->input('locale') ?? config('translatable.fallback_locale');

        $alreadyExists = $translationClass::where($attribute, $value)
            ->where('locale', $locale)
            ->whereIn($this->translationForeignKeyName, $relationDataIds)
            ->when($this->modelObject, function ($query) {
                $query->where('id', '!=', translation_id($this->modelObject));
            })
            ->exists();

        if ($alreadyExists) {
            $fail('validation.unique')->translate();
        }
    }
}
