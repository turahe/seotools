<?php

namespace Turahe\Metatags\Tests\Traits;

use Turahe\Metatags\Contracts\SEOTools;
use Turahe\Metatags\Tests\BaseTest;
use Turahe\Metatags\Tests\stubs\SeoToolsTraitStub;
use Mockery as m;
/**
 * Class SeoToolsTraitTest.
 */
class SeoToolsTraitTest extends BaseTest
{
    public function test_metatags_trait()
    {
        $stub = m::mock(SeoToolsTraitStub::class);

        $stub->shouldReceive('makeSeoForTests')
            ->andReturn($this->app['metatags']);

        $this->assertInstanceOf(SEOTools::class, $stub->makeSeoForTests());
    }
}
