<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeywordTranslation extends Model
{
    protected $fillable = [
        'keyword_id',

        'locale',
        'name',
    ];

    ## Relations

    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class);
    }
}
