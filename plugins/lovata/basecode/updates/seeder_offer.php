<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

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
}