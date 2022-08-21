<?php
namespace Turahe\SEOTools\Contracts;

interface SEOFriendly
{
    /**
     * Performs SEO settings.
     *
     * @param Tools $SEOTools
     */
    public function loadSEO(Tools $SEOTools);
}
