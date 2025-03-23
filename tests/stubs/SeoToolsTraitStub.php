<?php

namespace Turahe\SEOTools\Tests\stubs;

use Turahe\SEOTools\Traits\SEOTools;

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
