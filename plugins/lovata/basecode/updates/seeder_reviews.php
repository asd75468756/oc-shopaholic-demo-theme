<?php namespace Lovata\BaseCode\Updates;

use Lovata\BaseCode\Classes\AbstractModelSeeder;
use Lovata\Shopaholic\Models\Product;
use October\Rain\Argon\Argon;

/**
 * Class SeederReviews
 * @package Lovata\BaseCode\Updates
 */
class SeederReviews extends AbstractModelSeeder
{
    protected $sTableName = 'lovata_reviews_shopaholic_reviews';

    /** @var Product */
    protected $obProduct;

    protected $iMinuteCount = 0;

    protected $arNameList = [
        'Andrey',
        'Pavel',
        'Anna',
        'Bill',
        'Galina'
    ];

    protected function getModelName()
    {
        return \Lovata\ReviewsShopaholic\Models\Review::class;
    }

    /**
     * Seed table
     */
    protected function seed()
    {
        //Get product list
        $obProductList = Product::all();
        if ($obProductList->isEmpty()) {
            return;
        }

        /** @var Product $obProduct */
        foreach ($obProductList as $obProduct) {

            $this->obProduct = $obProduct;
            $iRandomReviewCount = mt_rand(2, 20);
            for ($i = 0; $i <= $iRandomReviewCount; $i++) {
                $this->process();
            }
        }

        //Get all reviews
        $obReviewList = \Lovata\ReviewsShopaholic\Models\Review::orderBy('id', 'desc')->get();
        $iProductID = 0;

        /** @var \Lovata\ReviewsShopaholic\Models\Review $obReview */
        foreach ($obReviewList as $obReview) {

            if($iProductID != $obReview->product_id) {
                $iProductID = $obReview->product_id;
                $this->iMinuteCount = 0;
            }

            $this->iMinuteCount += mt_rand(15, 180);

            $obReview->created_at = Argon::now()->subMinutes($this->iMinuteCount);
            $obReview->save();
        }
    }

    /**
     * Process row from csv file
     */
    protected function process()
    {
        $iRandomName = mt_rand(0, count($this->arNameList) - 1);
        $iRandom = mt_rand(1, 2);
        switch ($iRandom) {
            case 1:
                $iRandomRating = 5;
                break;
            default:
                $iRandomRating = mt_rand(1, 5);
                break;
        }

        $sModelName = $this->getModelName();
        $sModelName::create([
            'name'       => $this->arNameList[$iRandomName],
            'rating'     => $iRandomRating,
            'product_id' => $this->obProduct->id,
            'comment'    => 'My rating is ' . $iRandomRating . '.' . self::SMALL_TEXT,
        ]);
    }
}