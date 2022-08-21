<?php
namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

class PWA extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'pwa';
    }
}
