<?php namespace Lovata\BaseCode\Classes\Event;

use Cms\Classes\Page;
use System\Classes\PluginManager;

/**
 * Class ExtendPaymentGatewayHandler
 * @package Lovata\BaseCode\Classes\Event
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ExtendPaymentGatewayHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        if (!PluginManager::instance()->hasPlugin('Lovata.OmnipayShopaholic')) {
            return;
        }

        $obEvent->listen(\Lovata\OmnipayShopaholic\Classes\Helper\PaymentGateway::EVENT_GET_PAYMENT_GATEWAY_RETURN_URL, function ($obOrder, $obPaymentMethod) {
            /** @var \Lovata\OrdersShopaholic\Models\Order $obOrder */
            $sPageURL = Page::url('order_success', ['key' => $obOrder->secret_key]);

            return $sPageURL;
        });

        $obEvent->listen(\Lovata\OmnipayShopaholic\Classes\Helper\PaymentGateway::EVENT_GET_PAYMENT_GATEWAY_CANCEL_URL, function ($obOrder, $obPaymentMethod) {
            /** @var \Lovata\OrdersShopaholic\Models\Order $obOrder */
            $sPageURL = Page::url('order_success', ['key' => $obOrder->secret_key]);

            return $sPageURL;
        });
    }
}
