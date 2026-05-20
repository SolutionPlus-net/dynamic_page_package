<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionTranslation extends Model
{
    protected $fillable = [
        'section_id',

        'locale',
        'name',
        'title',
        'description',
    ];

    ## Relations

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
