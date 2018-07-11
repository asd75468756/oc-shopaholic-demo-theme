<?php namespace Lovata\BaseCode\Classes\Queue;

/**
 * Class GenerateCacheQueue
 * @package Lovata\BaseCode\Classes\Queue
 */
class GenerateCacheQueue
{
    public function fire($obJob, $arData)
    {
        $obJob->delete();

        $sItemClass = $arData['item'];
        $sItemClass::make($arData['id']);
    }
}