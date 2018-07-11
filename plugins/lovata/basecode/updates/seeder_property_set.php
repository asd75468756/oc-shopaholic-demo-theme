<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederPropertySet
 * @package Lovata\BaseCode\Updates
 */
class SeederPropertySet extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_set';
    protected $sFilePath = 'lovata/basecode/csv/property_set_list.csv';

    protected $arFieldList = ['name', 'code'];

    /** @var \Lovata\PropertiesShopaholic\Models\PropertySet */
    protected $obModel;

    /**
     * @return string
     */
    protected function getModelName()
    {
        return \Lovata\PropertiesShopaholic\Models\PropertySet::class;
    }
}