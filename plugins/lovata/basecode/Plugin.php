<?php namespace Lovata\BaseCode;

use System\Classes\PluginBase;
use System\Classes\PluginManager;

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