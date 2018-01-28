<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederPropertyValue
 * @package Lovata\BaseCode\Updates
 */
class SeederPropertyValue extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_properties_shopaholic_value';
    protected $sFilePath = 'lovata/basecode/csv/property_value_list.csv';

    protected $arFieldList = ['active', 'property_id', 'model', 'value'];

    protected function getModelName()
    {
        return \Lovata\PropertiesShopaholic\Models\PropertyValue::class;
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

            switch ($sFieldName) {
                case 'active':
                    $this->arModelData['active'] = true;
                    break;
                case 'model':
                    $this->arModelData['model'] = array_shift($this->arRowData) == 'product' ? \Lovata\Shopaholic\Models\Product::class : \Lovata\Shopaholic\Models\Offer::class;
                    break;
                default:
                    $this->arModelData[$sFieldName] = array_shift($this->arRowData);
            }
        }

        //Get product ID list
        $sProductIDList = array_shift($this->arRowData);
        if(empty($sProductIDList)) {
            return;
        }

        $arProductIDList = explode('|', $sProductIDList);
        foreach ($arProductIDList as $iProductID) {

            //Get product object
            if($this->arModelData['model'] == \Lovata\Shopaholic\Models\Product::class) {
                $obProduct = $this->arModelData['model']::find($iProductID);
            } else {
                /** @var  \Lovata\Shopaholic\Models\Offer $obOffer */
                $obOffer = $this->arModelData['model']::find($iProductID);
                if(empty($obOffer)) {
                    continue;
                }

                $obProduct = $obOffer->product;
            }

            if(empty($obProduct)) {
                continue;
            }

            $this->arModelData['product_id'] = $iProductID;
            $this->arModelData['category_id'] = $obProduct->category_id;

            $sModelName = $this->getModelName();
            $this->obModel = $sModelName::create($this->arModelData);
        }
    }
}