<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederShippingType
 * @package Lovata\BaseCode\Updates
 */
class SeederShippingType extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_orders_shopaholic_shipping_types';
    protected $sFilePath = 'lovata/basecode/csv/shipping_type_list.csv';

    protected $arFieldList = ['active', 'name', 'code', 'preview_text'];

    protected function getModelName()
    {
        return \Lovata\OrdersShopaholic\Models\ShippingType::class;
    }
}