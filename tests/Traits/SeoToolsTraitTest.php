<?php

namespace Turahe\SEOTools\Tests\Traits;

use Mockery as m;
use Turahe\SEOTools\Contracts\Tools;
use Turahe\SEOTools\Tests\BaseTest;
use Turahe\SEOTools\Tests\stubs\SeoToolsTraitStub;

/**
 * Class SeoToolsTraitTest.
 */
class SeoToolsTraitTest extends BaseTest
{
    public function test_seotools_trait()
    {
        $stub = m::mock(SeoToolsTraitStub::class);

        $stub->shouldReceive('makeSeoForTests')
            ->andReturn($this->app['seotools']);

        $this->assertInstanceOf(Tools::class, $stub->makeSeoForTests());
    }
}
