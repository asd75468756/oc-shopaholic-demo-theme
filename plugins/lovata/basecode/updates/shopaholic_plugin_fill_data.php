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
    const SMALL_TEXT = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
    const BIG_TEXT = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    protected $sImagePath = 'lovata/basecode/assets/img/';

    /**
     * Apply migration
     */
    public function up()
    {
        $this->sImagePath = plugins_path($this->sImagePath);

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
    public function down() {}

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

            $arData = [
                'active'       => true,
                'name'         => array_shift($arRow),
                'slug'         => array_shift($arRow),
            ];

            $arData['code'] = $arData['slug'];
            $arData['preview_text'] = 'Preview text. Brand '.$arData['name'].' '.self::SMALL_TEXT;
            $arData['description'] = '<p>Description text. Brand <strong>'.$arData['name'].'</strong></p><p>'.self::BIG_TEXT.'</p><p>'.self::BIG_TEXT.'</p>';

            //Create brand
            $obBrand = \Lovata\Shopaholic\Models\Brand::create($arData);

            $obImage = new File();
            $obImage->fromFile($this->sImagePath.'brand/'.array_shift($arRow));
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

            $arData = [
                'active'       => true,
                'name'         => array_shift($arRow),
                'slug'         => array_shift($arRow),
                'parent_id'    => array_shift($arRow),
                'nest_depth'   => array_shift($arRow),
                'nest_left'    => array_shift($arRow),
                'nest_right'   => array_shift($arRow),
            ];

            $arData['code'] = $arData['slug'];
            $arData['preview_text'] = 'Preview text. Category '.$arData['name'].' '.self::SMALL_TEXT;
            $arData['description'] = '<p>Description text. Category <strong>'.$arData['name'].'</strong></p><p>'.self::BIG_TEXT.'</p><p>'.self::BIG_TEXT.'</p>';

            //Create category
            $obCategory = \Lovata\Shopaholic\Models\Category::create($arData);

            $obImage = new File();
            $obImage->fromFile($this->sImagePath.'category/'.array_shift($arRow));
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

            $arData = [
                'active'       => true,
                'name'         => array_shift($arRow),
                'slug'         => array_shift($arRow),
                'code'         => array_shift($arRow),
                'category_id'  => array_shift($arRow),
                'brand_id'     => array_shift($arRow),
            ];

            $arData['preview_text'] = 'Preview text. Product '.$arData['name'].' '.self::SMALL_TEXT;
            $arData['description'] = '<p>Description text. Product <strong>'.$arData['name'].'</strong></p><p>'.self::BIG_TEXT.'</p><p>'.self::BIG_TEXT.'</p>';

            //Create product
            $obProduct = \Lovata\Shopaholic\Models\Product::create($arData);

            $arImageList = explode('|', array_shift($arRow));
            if(empty($arImageList)) {
                return;
            }

            $bFirst = true;
            foreach ($arImageList as $sFileName) {

                $obImage = new File();
                $obImage->fromFile($this->sImagePath.'product/'.$sFileName);
                $obProduct->images()->add($obImage);

                if($bFirst) {
                    $obImage = new File();
                    $obImage->fromFile($this->sImagePath.'product/'.$sFileName);
                    $obProduct->preview_image()->add($obImage);
                    $bFirst= false;
                }
            }

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
