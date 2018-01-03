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
        $this->truncateBrandTable();
        $this->truncateCategoryTable();
        $this->truncateProductTable();
        $this->truncateOfferTable();
        $this->truncateTranslateTable();

        DB::table('system_files')->truncate();

        $this->fillTranslateTable();
        $this->fillBrandTable();
        $this->fillCategoryTable();
        $this->fillProductTable();
        $this->fillOfferTable();
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

        $sFilePath = plugins_path('lovata/basecode/csv/brand_list.csv');
        if(!file_exists($sFilePath)) {
            return;
        }

        $obFile = fopen($sFilePath, 'r');
        while (($arRow = fgetcsv($obFile)) !== false) {
            if(empty($arRow)) {
                continue;
            }

            //Create brand
            $obBrand = \Lovata\Shopaholic\Models\Brand::create([
                'active'       => true,
                'name'         => array_shift($arRow),
                'slug'         => array_shift($arRow),
                'code'         => array_shift($arRow),
                'preview_text' => array_shift($arRow),
                'description'  => array_shift($arRow),
            ]);

            $obImage = new File();
            $obImage->fromFile(plugins_path(array_shift($arRow)));
            $obBrand->preview_image()->add($obImage);
            $obBrand->save();
        }
    }

    /**
     * Fill category list
     */
    protected function fillCategoryTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_categories')) {
            return;
        }

        $sFilePath = plugins_path('lovata/basecode/csv/category_list.csv');
        if(!file_exists($sFilePath)) {
            return;
        }

        $obFile = fopen($sFilePath, 'r');
        while (($arRow = fgetcsv($obFile)) !== false) {
            if (empty($arRow)) {
                continue;
            }

            //Create category
            $obCategory = \Lovata\Shopaholic\Models\Category::create([
                'active'       => true,
                'name'         => array_shift($arRow),
                'slug'         => array_shift($arRow),
                'code'         => array_shift($arRow),
                'preview_text' => array_shift($arRow),
                'description'  => array_shift($arRow),
                'parent_id'    => array_shift($arRow),
                'nest_depth'   => array_shift($arRow),
                'nest_left'    => array_shift($arRow),
                'nest_right'   => array_shift($arRow),
            ]);

            //array_shift($arRow);
            //array_shift($arRow);

            $obImage = new File();
            $obImage->fromFile(plugins_path(array_shift($arRow)));
            $obCategory->preview_image()->add($obImage);
            $obCategory->save();
        }
    }

    /**
     * Fill product list
     */
    protected function fillProductTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_products')) {
            return;
        }

        $sFilePath = plugins_path('lovata/basecode/csv/product_list.csv');
        if(!file_exists($sFilePath)) {
            return;
        }

        $obFile = fopen($sFilePath, 'r');
        while (($arRow = fgetcsv($obFile)) !== false) {
            if(empty($arRow)) {
                continue;
            }

            //Create product
            $obProduct = \Lovata\Shopaholic\Models\Product::create([
                'active'       => true,
                'name'         => array_shift($arRow),
                'slug'         => array_shift($arRow),
                'code'         => array_shift($arRow),
                'preview_text' => array_shift($arRow),
                'description'  => array_shift($arRow),
                'category_id'  => array_shift($arRow),
                'brand_id'     => array_shift($arRow),
            ]);

            $obImage = new File();
            $obImage->fromFile(plugins_path(array_shift($arRow)));
            $obProduct->preview_image()->add($obImage);
            $obProduct->save();
        }
    }


    /**
     * Fill offer list
     */
    protected function fillOfferTable()
    {
        if(!Schema::hasTable('lovata_shopaholic_offers')) {
            return;
        }

        $sFilePath = plugins_path('lovata/basecode/csv/offer_list.csv');
        if(!file_exists($sFilePath)) {
            return;
        }

        $obFile = fopen($sFilePath, 'r');
        while (($arRow = fgetcsv($obFile)) !== false) {
            if(empty($arRow)) {
                continue;
            }

            //Create offer
            \Lovata\Shopaholic\Models\Offer::create([
                'active'       => true,
                'name'         => array_shift($arRow),
                'code'         => array_shift($arRow),
                'preview_text' => array_shift($arRow),
                'description'  => array_shift($arRow),
                'price'        => array_shift($arRow),
                'old_price'    => array_shift($arRow),
                'quantity'     => array_shift($arRow),
                'product_id'   => array_shift($arRow),
            ]);
        }
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
