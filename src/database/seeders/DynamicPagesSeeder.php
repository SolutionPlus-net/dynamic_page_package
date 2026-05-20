<?php

namespace Otas\DynamicPages\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Otas\DynamicPages\Models\CustomAttribute;
use Otas\DynamicPages\Models\Page;
use Otas\DynamicPages\Models\Section;
use Otas\DynamicPages\Models\SectionItem;

class DynamicPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
    }

    public static function seedContent(array $pages): void
    {
        DB::transaction(function () use ($pages) {
            foreach ($pages as $pageData):
                $page = self::fillPageData(pageData: $pageData);

                foreach ($pageData['sections'] as $sectionData):
                    self::fillSectionData(page: $page, sectionData: $sectionData);
                endforeach;
            endforeach;
        });
    }

    private static function fillPageData(array $pageData): Page
    {
        $page = Page::where('path', $pageData['page_path'])->first();

        if (!$page) {
            $page = Page::create([
                'path' => $pageData['page_path']
            ]);

            self::translateModel(model: $page, translationData: $pageData['translation_data']);
        }

        return $page;
    }

    private static function fillSectionData(Page $page, array $sectionData): void
    {
        $section = Section::where('identifier', $sectionData['identifier'])->first();

        if (!$section) {
            $section = $page->sections()->create([
                'identifier' => $sectionData['identifier'],
                'has_title' => $sectionData['has_title'],
                'has_description' => $sectionData['has_description'],
                'images_count' => $sectionData['images_count'],
                'has_items' => $sectionData['has_items'],
                'item_images_count' => $sectionData['item_images_count'],
                'has_items_title' => $sectionData['has_items_title'],
                'has_items_description' => $sectionData['has_items_description'],
                'title_validation_text' => $sectionData['title_validation_text'],
                'description_validation_text' => $sectionData['description_validation_text'],
            ]);

            self::translateModel(model: $section, translationData: $sectionData['translation_data']);
        }

        if (array_key_exists('items', $sectionData)) {
            foreach ($sectionData['items'] as $itemData):
                self::fillSectionItemData(section: $section, itemData: $itemData);
            endforeach;
        }

        if (array_key_exists('custom_attributes', $sectionData)) {
            foreach ($sectionData['custom_attributes'] as $customAttributeData):
                self::fillCustomAttributesData(relatedObject: $section, customAttributeData: $customAttributeData);
            endforeach;
        }
    }

    private static function fillSectionItemData(Section $section, array $itemData): void
    {
        $sectionItem = SectionItem::where('identifier', $itemData['identifier'])->first();

        if (!$sectionItem) {
            $sectionItem = $section->sectionItems()->create([
                'identifier' => $itemData['identifier'],
                'title_validation_text' => $itemData['title_validation_text'],
                'description_validation_text' => $itemData['description_validation_text'],
            ]);

            self::translateModel(model: $sectionItem, translationData: $itemData['translation_data']);
        }

        if (array_key_exists('custom_attributes', $itemData)) {
            foreach ($itemData['custom_attributes'] as $customAttributeData):
                self::fillCustomAttributesData(relatedObject: $sectionItem, customAttributeData: $customAttributeData);
            endforeach;
        }
    }

    private static function fillCustomAttributesData(Section|SectionItem $relatedObject, array $customAttributeData): void
    {
        $customAttribute = CustomAttribute::where('key', $customAttributeData['key'])->first();

        if (!$customAttribute) {
            $customAttribute = $relatedObject->customAttributes()->create([
                'key' => $customAttributeData['key'],
                'value_validation_text' => $customAttributeData['value_validation_text'],
            ]);

            self::translateModel(model: $customAttribute, translationData: $customAttributeData['translation_data']);
        }
    }

    private static function translateModel($model, array $translationData): void
    {
        foreach ($translationData as $locale => $data) {
            $model->translate($data, $locale);
        }
    }
}
