<?php

namespace Turahe\Metatags\Tests;

use Mockery;
use DOMDocument;
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
        return [\Turahe\Metatags\Providers\MetaTagsServiceProvider::class];
    }

    /**
     * @param $string
     * @return \DOMDocument
     */
    protected function makeDomDocument($string)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($string);

        return $dom;
    }
}
