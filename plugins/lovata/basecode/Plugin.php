<?php namespace Lovata\BaseCode;

use Event;
use System\Classes\PluginBase;
use System\Classes\PluginManager;

use Lovata\BaseCode\Classes\Event\ExtendPaymentGatewayHandler;

/**
 * Class Plugin
 * @package Lovata\BaseCode
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Plugin extends PluginBase
{
    /**
     * Register twig filters and functions
     * @return array
     */
    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'has_plugin' => function($sPluginName) { return $this->checkPlugin($sPluginName); },
            ],
        ];
    }

    /**
     * Register plugin method
     */
    public function register()
    {
        $this->registerConsoleCommand('shopaholic:generate.cache', 'Lovata\BaseCode\Classes\Console\GenerateCacheCommand');
    }

    /**
     * Boot plugin method
     */
    public function boot()
    {
        $this->addEventListener();
    }

    /**
     * Add event listeners
     */
    protected function addEventListener()
    {
        Event::subscribe(ExtendPaymentGatewayHandler::class);
    }

    /**
     * Check [lugin by name
     * @param string $sPluginName
     * @return bool
     */
    protected function checkPlugin($sPluginName)
    {
        if(empty($sPluginName)) {
            return false;
        }

        $bResult = PluginManager::instance()->hasPlugin($sPluginName) && !PluginManager::instance()->isDisabled($sPluginName);
        return $bResult;
    }
}