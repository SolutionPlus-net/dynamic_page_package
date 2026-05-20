<?php

namespace Otas\DynamicPages\Models;

use Otas\Mediable\Models\Media;
use Otas\Mediable\Traits\Mediable;
use Illuminate\Database\Eloquent\Model;
use Otas\Filterable\Traits\Filterable;
use Otas\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory, Translatable, Filterable, Mediable;

    public $translatedAttributes = [
        'name',
        'title',
        'description',
    ];

    protected $fillable = [
        'page_id',
        'identifier',

        'has_title',
        'has_description',
        'images_count',

        'has_items',
        'item_images_count',
        'has_items_title',
        'has_items_description',

        'title_validation_text',
        'description_validation_text',
    ];

    protected $casts = [
        'has_title' => 'boolean',
        'has_description' => 'boolean',
        'has_items' => 'boolean',
        'has_items_title' => 'boolean',
        'has_items_description' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'identifier';
    }

    ## Relations

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function sectionItems(): HasMany
    {
        return $this->hasMany(SectionItem::class);
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
        if ($this->sectionItems()->count() > 0 || $this->customAttributes()->count() > 0) {
            return false;
        }

        $this->sectionItems()->each(function ($sectionItem) {
            $sectionItem->remove();
        });
        $this->customAttributes()->each(function ($customAttribute) {
            $customAttribute->remove();
        });
        $this->deleteAllMedia();
        $this->deleteTranslations();
        $this->delete();

        return true;
    }
}
