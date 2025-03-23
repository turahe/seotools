<?php

namespace Turahe\SEOTools\Tests;

use DOMDocument;
use Mockery;
use Orchestra\Testbench\TestCase;

/**
 * Class BaseTest.
 */
abstract class BaseTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [\Turahe\SEOTools\Providers\SEOToolsServiceProvider::class];
    }

    protected function makeDomDocument($string): DOMDocument
    {
        $dom = new DOMDocument;
        $dom->loadHTML($string);

        return $dom;
    }
}
