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
