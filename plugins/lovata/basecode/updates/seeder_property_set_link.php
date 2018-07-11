<?php namespace Lovata\BaseCode\Updates;

use DB;
use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederPropertySetLink
 * @package Lovata\BaseCode\Updates
 */
class SeederPropertySetLink extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_set_category_link';
    protected $sFilePath = 'lovata/basecode/csv/property_set_link_list.csv';

    protected $arFieldList = ['set_id', 'category_id'];

    protected function getModelName()
    {
        return null;
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

        try {
            DB::table($this->sTableName)->insert($this->arModelData);
        } catch (\October\Rain\Database\ModelException $obException) {
            echo $obException->getMessage();
        }
    }
}