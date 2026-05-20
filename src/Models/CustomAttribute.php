<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Otas\Filterable\Traits\Filterable;
use Otas\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomAttribute extends Model
{
    use HasFactory;
    use Translatable;
    use Filterable;

    public $translatedAttributes = [
        'name',
        'value',
    ];

    protected $fillable = [
        'related_object_id',
        'related_object_type',
        'key',
        'value_validation_text',
    ];

    public function getRouteKeyName(): string
    {
        return 'key';
    }

    ## Relations

    public function relatedObject(): MorphTo
    {
        return $this->morphTo('related_object');
    }

    ## Getters & Setters

    ## Scopes

    ## Other Methods

    public function remove(): bool
    {
        $this->deleteTranslations();
        $this->delete();

        return true;
    }
}
