<?php

namespace Turahe\Metatags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * SEOTools is a facade for the `SEOTools` implementation access.
 *
 * @see \Turahe\Metatags\Contracts\SEOTools
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\Metatags\Contracts\MetaTags metatags()
 * @method static \Turahe\Metatags\Contracts\OpenGraph opengraph()
 * @method static \Turahe\Metatags\Contracts\TwitterCards twitter()
 * @method static \Turahe\Metatags\Contracts\JsonLd jsonLd()
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti jsonLdMulti()
 * @method static \Turahe\Metatags\Contracts\SEOTools setTitle(string $title, bool $appendDefault = true)
 * @method static \Turahe\Metatags\Contracts\SEOTools setDescription(string $description)
 * @method static \Turahe\Metatags\Contracts\SEOTools setCanonical(string $url)
 * @method static \Turahe\Metatags\Contracts\SEOTools addImages(array $urls)
 * @method static string getTitle(bool $session = false)
 */
class SEOTools extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools';
    }
}
