<?php

namespace Turahe\SEOTools\Tests\Traits;

use Turahe\SEOTools\Contracts\Tools;
use Turahe\SEOTools\Tests\BaseTest;
use Turahe\SEOTools\Tests\stubs\SeoToolsTraitStub;
use Mockery as m;
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
