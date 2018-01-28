<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;

/**
 * Class SeederCategory
 * @package Lovata\BaseCode\Updates
 */
class SeederCategory extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_shopaholic_categories';
    protected $sFilePath = 'lovata/basecode/csv/category_list.csv';

    protected $arFieldList = ['active', 'name', 'slug', 'parent_id', 'nest_depth', 'nest_left', 'nest_right'];

    /** @var \Lovata\Shopaholic\Models\Category */
    protected $obModel;

    protected function getModelName()
    {
        return \Lovata\Shopaholic\Models\Category::class;
    }

    /**
     * Process row from csv file
     */
    protected function process()
    {
        parent::process();

        $this->obModel->code = $this->obModel->slug;
        $this->fillPreviewText('Category');
        $this->fillDescription('Category');

        $this->createPreviewImage('category');
    }
}