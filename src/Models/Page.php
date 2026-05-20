<?php

namespace Otas\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Otas\Filterable\Traits\Filterable;
use Otas\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Page extends Model
{
    use HasFactory, Translatable, Filterable;

    public $translatedAttributes = [
        'name',
        'title',
        'description',
    ];

    protected $fillable = [
        'path',
    ];

    public function getRouteKeyName(): string
    {
        return 'path';
    }

    ## Relations

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function keywords(): MorphToMany
    {
        return $this->morphToMany(Keyword::class, 'related_object', 'keyword_related_objects');
    }

    public function visibleKeywords()
    {
        return $this->keywords()->visible();
    }

    ## Getters & Setters

    ## Scopes

    ## Other Methods

    public function remove(): bool
    {
        if ($this->sections()->count() > 0 || $this->keywords()->count() > 0) {
            return false;
        }

        $this->sections()->each(function ($section) {
            $section->remove();
        });
        $this->keywords()->each(function ($keyword) {
            $keyword->remove();
        });
        $this->deleteTranslations();
        $this->delete();

        return true;
    }
}
