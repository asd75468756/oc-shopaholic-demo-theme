<?php namespace Lovata\BaseCode\Updates;

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

        $this->createModelImages('product');
    }
}