<?php namespace Lovata\BaseCode\Updates;

use System\Classes\PluginManager;
use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederProduct
 * @package Lovata\BaseCode\Updates
 */
class SeederProduct extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_shopaholic_products';
    protected $sFilePath = 'lovata/basecode/csv/product_list.csv';

    protected $arFieldList = ['active', 'name', 'slug', 'code', 'category_id', 'brand_id'];

    protected function getModelName()
    {
        return \Lovata\Shopaholic\Models\Product::class;
    }

    /**
     * Process row from csv file
     */
    protected function process()
    {
        parent::process();

        $this->fillPreviewText('Product');
        $this->fillDescription('Product');

        if (PluginManager::instance()->hasPlugin('Lovata.PopularityShopaholic')) {
            $this->obModel->popularity = random_int(0, 1000);
        }

        $this->createModelImages('product');
    }

    /**
     * Seed table
     */
    protected function seed()
    {
        if(empty($this->obFile) || !is_resource($this->obFile)) {
            return;
        }

        //Skip first line
        fgetcsv($this->obFile);

        $iIncreaseProductCount = (int) env('INCREASE_PRODUCT_COUNT', 1);
        if ($iIncreaseProductCount < 1) {
            $iIncreaseProductCount = 1;
        }

        $arRowList = [];

        //Process rows of csv file
        while (($arRow = fgetcsv($this->obFile)) !== false) {

            //Always skip first column
            array_shift($arRow);
            if(empty($arRow)) {
                continue;
            }



            $arRowList[] = $arRow;
        }

        for ($i = 0; $i < $iIncreaseProductCount; $i++) {
            foreach ($arRowList as $arRow) {
                $this->arRowData = $arRow;
                $this->arRowData[0] = $arRow[0].'-'.$i;
                $this->arRowData[1] = $arRow[1].'-'.$i;
                $this->arRowData[2] = $arRow[2].'-'.$i;

                $this->process();
            }
        }
    }

    /**
     * Create images
     * @param string $sFolderName
     */
    protected function createModelImages($sFolderName)
    {
        $iIncreaseProductCount = (int) env('INCREASE_PRODUCT_COUNT', 1);
        if ($iIncreaseProductCount > 10) {
            return;
        }

        parent::createModelImages($sFolderName);
    }

    /**
     * Create new preview image
     * @param string $sFolderName
     */
    protected function createPreviewImage($sFolderName)
    {
        $iIncreaseProductCount = (int) env('INCREASE_PRODUCT_COUNT', 1);
        if ($iIncreaseProductCount > 10) {
            return;
        }

        parent::createPreviewImage($sFolderName);
    }
}