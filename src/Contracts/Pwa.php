<?php
namespace Turahe\SEOTools\Contracts;

interface Pwa
{
    /**
     * Takes the default title.
     *
     * @param bool $minify
     * @return string
     */
    public function generate(bool $minify = true): string;

    /**
     * Reset all data.
     *
     * @return void
     */
    public function manifestJson(): array;
}
