<?php

namespace Turahe\Metatags\Tests\stubs;
use Turahe\Metatags\Traits\SEOTools;

/**
 * Class SeoToolsTraitStub
 */
class SeoToolsTraitStub
{
    use SEOTools;

    public function makeSeoForTests()
    {
        return $this->seo();
    }
}
