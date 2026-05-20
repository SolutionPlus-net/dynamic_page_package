<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageTranslation extends Model
{
    protected $fillable = [
        'page_id',

        'locale',
        'name',
        'title',
        'description',
    ];

    ## Relations

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
