<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomAttributeTranslation extends Model
{
    protected $fillable = [
        'custom_attribute_id',

        'locale',
        'name',
        'value',
    ];

    ## Relations

    public function customAttribute(): BelongsTo
    {
        return $this->belongsTo(CustomAttribute::class);
    }
}
