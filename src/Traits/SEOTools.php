<?php

namespace Turahe\SEOTools\Traits;

use Turahe\SEOTools\Contracts\SEOFriendly;

trait SEOTools
{
    /**
     * @return \Turahe\SEOTools\Contracts\Tools
     */
    protected function seo()
    {
        return app('seotools');
    }

    /**
     * @return \Turahe\SEOTools\Contracts\Tools
     */
    protected function loadSEO(SEOFriendly $friendly)
    {
        $SEO = $this->seo();

        $friendly->loadSEO($SEO);

        return $SEO;
    }
}
