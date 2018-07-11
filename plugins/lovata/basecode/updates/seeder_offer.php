<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;
use Lovata\Shopaholic\Models\Product;

/**
 * Class SeederOffer
 * @package Lovata\BaseCode\Updates
 */
class SeederOffer extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_shopaholic_offers';
    protected $sFilePath = 'lovata/basecode/csv/offer_list.csv';

    protected $arFieldList = ['active', 'name', 'code', 'price', 'old_price', 'product_id'];

    /** @var \Lovata\Shopaholic\Models\Offer */
    protected $obModel;

    /**
     * @return string
     */
    protected function getModelName()
    {
        return \Lovata\Shopaholic\Models\Offer::class;
    }

    /**
     * Process row data
     */
    protected function process()
    {
        parent::process();

        $this->obModel->quantity = random_int(0, 100);
        $this->obModel->save();
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

        $iProductCount = Product::count() / $iIncreaseProductCount;

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
                $this->arRowData[4] = $arRow[4] + $i * $iProductCount;

                $this->process();
            }
        }
    }
}