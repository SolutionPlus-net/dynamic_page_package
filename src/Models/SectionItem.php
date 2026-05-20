<?php

namespace Otas\DynamicPages\Models;

use Mabrouk\Mediable\Models\Media;
use Mabrouk\Mediable\Traits\Mediable;
use Illuminate\Database\Eloquent\Model;
use Mabrouk\Filterable\Traits\Filterable;
use Mabrouk\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionItem extends Model
{
    use HasFactory;
    use Translatable;
    use Filterable;
    use Mediable;

    public $translatedAttributes = [
        'name',
        'title',
        'description',
    ];

    protected $fillable = [
        'section_id',
        'identifier',
        'title_validation_text',
        'description_validation_text',
    ];

    public function getRouteKeyName(): string
    {
        return 'identifier';
    }

    ## Relations

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function customAttributes(): MorphMany
    {
        return $this->morphMany(CustomAttribute::class, 'related_object');
    }

    ## Getters & Setters

    public function getImagesAttribute()
    {
        return $this->media;
    }

    public function getHasCustomAttributesAttribute()
    {
        return $this->customAttributes()->exists();
    }

    ## Scopes

    ## Other Methods

    public function removeMedia(Media $media)
    {
        return $media->remove();
    }

    public function remove(): bool
    {
        if ($this->customAttributes()->count() > 0) {
            return false;
        }

        $this->customAttributes()->each(function ($customAttribute) {
            $customAttribute->remove();
        });
        $this->deleteAllMedia();
        $this->deleteTranslations();
        $this->delete();

        return true;
    }
}
