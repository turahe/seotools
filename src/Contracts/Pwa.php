<?php

namespace Turahe\SEOTools\Contracts;

use Illuminate\Support\Collection;

interface Pwa
{
    /**
     * Takes the default title.
     *
     * @return string
     */
    public function generate($minify = true);

    /**
     * Reset all data.
     *
     * @return void
     */
    public function manifestJson(): Collection;

}
