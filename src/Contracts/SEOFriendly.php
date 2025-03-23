<?php

namespace Turahe\SEOTools\Contracts;

interface SEOFriendly
{
    /**
     * Performs SEO settings.
     */
    public function loadSEO(Tools $SEOTools);
}
