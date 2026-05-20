<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeywordRelatedObject extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'keyword_id',
        'related_object_id',
        'related_object_type',
    ];

    ## Relations

    public function relatedObject(): MorphTo
    {
        return $this->morphTo();
    }

    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class, 'keyword_id');
    }
}
