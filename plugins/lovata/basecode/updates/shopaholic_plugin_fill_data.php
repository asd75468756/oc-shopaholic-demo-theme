<?php namespace Lovata\BaseCode\Updates;

use DB;
use Lovata\Shopaholic\Models\Brand;
use Schema;
use System\Classes\PluginManager;
use October\Rain\Database\Updates\Migration;
use System\Models\File;

/**
 * Class ShopaholicPluginFillData
 * @package Lovata\BaseCode\Updates
 */
class ShopaholicPluginFillData extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        $this->fillTranslateTable();
        $this->fillBrandTable();
        $this->fillCategoryTable();
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        $this->truncateBrandTable();
        $this->truncateCategoryTable();
        $this->truncateProductTable();
        $this->truncateOfferTable();
        $this->truncateTranslateTable();

        DB::table('system_files')->truncate();
    }

    /**
     * Fill brand list
     */
    protected function fillBrandTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_brands')) {
            return;
        }

        //Create brand Samsung
        $obBrand = \Lovata\Shopaholic\Models\Brand::create([
            'active'       => true,
            'name'         => 'Samsung',
            'slug'         => 'samsung',
            'code'         => 'samsung',
            'preview_text' => 'Preview text. Brand Samsung',
            'description'  => '<p>Description text. Brand <strong>Samsung</strong></p>'
        ]);

        $obFile = new File();
        $obFile->fromFile(plugins_path('lovata/basecode/assets/img/samsung_preview_image.png'));

        $obBrand->preview_image()->add($obFile);
        $obBrand->save();

        //Create brand Apple
        $obBrand = \Lovata\Shopaholic\Models\Brand::create([
            'active'       => true,
            'name'         => 'Apple',
            'slug'         => 'apple',
            'code'         => 'apple',
            'preview_text' => 'Preview text. Brand Apple',
            'description'  => '<p>Description text. Brand <strong>Apple</strong></p>'
        ]);

        $obFile = new File();
        $obFile->fromFile(plugins_path('lovata/basecode/assets/img/apple_preview_image.jpg'));

        $obBrand->preview_image()->add($obFile);
        $obBrand->save();
    }

    /**
     * Fill category list
     */
    protected function fillCategoryTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_categories')) {
            return;
        }

        //Create category Mobile
        $obCategory = \Lovata\Shopaholic\Models\Category::create([
            'active'       => true,
            'name'         => 'Mobile',
            'slug'         => 'mobile',
            'code'         => 'mobile',
            'preview_text' => 'Preview text. Category "Mobile"',
            'description'  => '<p>Description text. Category <strong>"Mobile"</strong></p>',
            'parent_id'    => 0,
            'nest_depth'   => 1,
            'nest_left'    => 0,
            'nest_right'   => 2,
        ]);

        $obFile = new File();
        $obFile->fromFile(plugins_path('lovata/basecode/assets/img/mobile_preview_image.png'));

        $obCategory->preview_image()->add($obFile);
        $obCategory->save();

        //Create category Phone
        $obCategory = \Lovata\Shopaholic\Models\Category::create([
            'active'       => true,
            'name'         => 'Phones',
            'slug'         => 'phones',
            'code'         => 'phones',
            'preview_text' => 'Preview text. Category "Phones"',
            'description'  => '<p>Description text. Category <strong>"Phones"</strong></p>',
            'parent_id'    => 1,
            'nest_depth'   => 2,
            'nest_left'    => 1,
            'nest_right'   => 3,
        ]);

        $obFile = new File();
        $obFile->fromFile(plugins_path('lovata/basecode/assets/img/phones_preview_image.png'));

        $obCategory->preview_image()->add($obFile);
        $obCategory->save();

        //Create category Tablet
        $obCategory = \Lovata\Shopaholic\Models\Category::create([
            'active'       => true,
            'name'         => 'Tablets',
            'slug'         => 'tablets',
            'code'         => 'tablets',
            'preview_text' => 'Preview text. Category "Tablets"',
            'description'  => '<p>Description text. Category <strong>"Tablets"</strong></p>',
            'parent_id'    => 1,
            'nest_depth'   => 2,
            'nest_left'    => 2,
            'nest_right'   => 4,
        ]);

        $obFile = new File();
        $obFile->fromFile(plugins_path('lovata/basecode/assets/img/tablet_preview_image.png'));

        $obCategory->preview_image()->add($obFile);
        $obCategory->save();
    }

    /**
     * Fill translate table
     */
    protected function fillTranslateTable()
    {
        if(!PluginManager::instance()->hasPlugin('RainLab.Translate')) {
            return;
        }

        //Get lang by code
        $obLang = \RainLab\Translate\Models\Locale::findByCode('my');
        if(!empty($obLang)) {
            return;
        }

        \RainLab\Translate\Models\Locale::create([
            'code' => 'my',
            'name' => 'My lang',
            'is_enabled' => true,
            'sort_order' => \RainLab\Translate\Models\Locale::count() + 1,
        ]);
    }

    /**
     * Clear brands table
     */
    protected function truncateBrandTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_brands')) {
            return;
        }

        DB::table('lovata_shopaholic_brands')->truncate();
    }

    /**
     * Clear categories table
     */
    protected function truncateCategoryTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_categories')) {
            return;
        }

        DB::table('lovata_shopaholic_categories')->truncate();
    }

    /**
     * Clear products table
     */
    protected function truncateProductTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_products')) {
            return;
        }

        DB::table('lovata_shopaholic_products')->truncate();
    }

    /**
     * Clear offers table
     */
    protected function truncateOfferTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_offers')) {
            return;
        }

        DB::table('lovata_shopaholic_offers')->truncate();
    }

    /**
     * Clear translate table
     */
    protected function truncateTranslateTable()
    {
        if(!Schema::hasTable('rainlab_translate_attributes')) {
            return;
        }

        DB::table('rainlab_translate_attributes')->truncate();
    }
}
