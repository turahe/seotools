<?php

namespace Turahe\Metatags\Traits;

use Turahe\Metatags\Contracts\SEOFriendly;

trait SEOTools
{
    /**
     * @return \Turahe\Metatags\Contracts\SEOTools
     */
    protected function seo()
    {
        return app('metatags');
    }

    /**
     * @param SEOFriendly $friendly
     *
     * @return \Turahe\Metatags\Contracts\SEOTools
     */
    protected function loadSEO(SEOFriendly $friendly)
    {
        $SEO = $this->seo();

        $friendly->loadSEO($SEO);

        return $SEO;
    }
}
