<?php namespace Lovata\BaseCode\Updates;

use DB;
use Schema;
use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederOfferPropertyLink
 * @package Lovata\BaseCode\Updates
 */
class SeederOfferPropertyLink extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_set_offer_link';
    protected $sFilePath = 'lovata/basecode/csv/offer_property_link_list.csv';

    protected $arFieldList = ['property_id', 'set_id'];

    /** @var \Lovata\PropertiesShopaholic\Models\Property */
    protected $obModel;

    /**
     * @return string
     */
    protected function getModelName()
    {
        return \Lovata\PropertiesShopaholic\Models\PropertyOfferLink::class;
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