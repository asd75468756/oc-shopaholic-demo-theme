<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederPaymentMethod
 * @package Lovata\BaseCode\Updates
 */
class SeederPaymentMethod extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_orders_shopaholic_payment_methods';
    protected $sFilePath = 'lovata/basecode/csv/payment_method_list.csv';

    protected $arFieldList = ['active', 'name', 'code', 'preview_text'];

    protected function getModelName()
    {
        return \Lovata\OrdersShopaholic\Models\PaymentMethod::class;
    }
}