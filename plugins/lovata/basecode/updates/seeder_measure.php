<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederMeasure
 * @package Lovata\BaseCode\Updates
 */
class SeederMeasure extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_measure';
    protected $sFilePath = 'lovata/basecode/csv/measure_list.csv';

    protected $arFieldList = ['name'];

    protected function getModelName()
    {
        return \Lovata\PropertiesShopaholic\Models\Measure::class;
    }
}