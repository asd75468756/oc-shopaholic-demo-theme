<?php namespace Lovata\BaseCode\Classes\Console;

use Lovata\BaseCode\Classes\Queue\GenerateCacheQueue;
use Queue;
use Illuminate\Console\Command;

/**
 * Class GenerateCacheCommand
 * @package Lovata\BaseCode\Classes\Console
 */
class GenerateCacheCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shopaholic:generate.cache';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for Item classes';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache(\Lovata\Shopaholic\Models\Brand::class, \Lovata\Shopaholic\Classes\Item\BrandItem::class);
        $this->generateCache(\Lovata\Shopaholic\Models\Category::class, \Lovata\Shopaholic\Classes\Item\CategoryItem::class);
        $this->generateCache(\Lovata\Shopaholic\Models\Offer::class, \Lovata\Shopaholic\Classes\Item\OfferItem::class);
        $this->generateCache(\Lovata\Shopaholic\Models\Product::class, \Lovata\Shopaholic\Classes\Item\ProductItem::class);

        $this->generateCache(\Lovata\ReviewsShopaholic\Models\Review::class, \Lovata\ReviewsShopaholic\Classes\Item\ReviewItem::class);

        $this->generateCache(\Lovata\PropertiesShopaholic\Models\Group::class, \Lovata\PropertiesShopaholic\Classes\Item\GroupItem::class);
        $this->generateCache(\Lovata\PropertiesShopaholic\Models\Measure::class, \Lovata\PropertiesShopaholic\Classes\Item\MeasureItem::class);
        $this->generateCache(\Lovata\PropertiesShopaholic\Models\Property::class, \Lovata\PropertiesShopaholic\Classes\Item\PropertyItem::class);
        $this->generateCache(\Lovata\PropertiesShopaholic\Models\PropertySet::class, \Lovata\PropertiesShopaholic\Classes\Item\PropertySetItem::class);
        $this->generateCache(\Lovata\PropertiesShopaholic\Models\PropertyValue::class, \Lovata\PropertiesShopaholic\Classes\Item\PropertyValueItem::class);
    }

    protected function generateCache($sModelClass, $sItemClass)
    {
        if (!class_exists($sModelClass) || !class_exists($sItemClass)) {
            return;
        }

        //Get all models
        $obElementList = $sModelClass::all();
        if ($obElementList->isEmpty()) {
            return;
        }

        foreach ($obElementList as $obElement) {

            $iElementID = $obElement->id;
            Queue::pushOn( env('BRANCH_NAME').'cache', GenerateCacheQueue::class, ['item' => $sItemClass, 'id' => $iElementID]);
        }
    }
}
