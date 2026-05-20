<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionItemTranslation extends Model
{
    protected $fillable = [
        'section_item_id',

        'locale',
        'name',
        'title',
        'description',
    ];

    ## Relations

    public function sectionItem(): BelongsTo
    {
        return $this->belongsTo(SectionItem::class);
    }
}
