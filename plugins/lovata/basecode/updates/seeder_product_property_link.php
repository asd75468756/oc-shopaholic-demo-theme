<?php namespace Lovata\BaseCode\Updates;

use DB;
use Schema;
use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederProductPropertyLink
 * @package Lovata\BaseCode\Updates
 */
class SeederProductPropertyLink extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_set_product_link';
    protected $sFilePath = 'lovata/basecode/csv/product_property_link_list.csv';

    protected $arFieldList = ['property_id', 'set_id'];

    /** @var \Lovata\PropertiesShopaholic\Models\Property */
    protected $obModel;

    /**
     * @return string
     */
    protected function getModelName()
    {
        return \Lovata\PropertiesShopaholic\Models\PropertyProductLink::class;
    }

    /**
     * Process row from csv file
     */
    protected function process()
    {
        if(empty($this->arRowData) || empty($this->arFieldList)) {
            return;
        }

        //Clear model data array
        $this->arModelData = [];

        foreach ($this->arFieldList as $sFieldName) {
            $this->arModelData[$sFieldName] = array_shift($this->arRowData);
        }

        $this->arModelData['groups'] = json_encode([array_shift($this->arRowData)]);

        if(Schema::hasColumn($this->sTableName, 'in_filter')) {
            $this->arModelData['in_filter'] = array_shift($this->arRowData);
            $this->arModelData['filter_type'] = array_shift($this->arRowData);
        }

        DB::table($this->sTableName)->insert($this->arModelData);
    }
}