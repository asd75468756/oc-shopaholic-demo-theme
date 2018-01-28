<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederPropertyGroup
 * @package Lovata\BaseCode\Updates
 */
class SeederPropertyGroup extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_groups';
    protected $sFilePath = 'lovata/basecode/csv/property_group_list.csv';

    protected $arFieldList = ['name', 'code'];

    protected function getModelName()
    {
        return \Lovata\PropertiesShopaholic\Models\Group::class;
    }
}