<?php
namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Tools is a facade for the `Tools` implementation access.
 *
 * @see \Turahe\SEOTools\Contracts\Tools
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\SEOTools\Contracts\Meta metatags()
 * @method static \Turahe\SEOTools\Contracts\OpenGraph opengraph()
 * @method static \Turahe\SEOTools\Contracts\TwitterCards twitter()
 * @method static \Turahe\SEOTools\Contracts\JsonLd jsonLd()
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti jsonLdMulti()
 * @method static \Turahe\SEOTools\Contracts\Tools setTitle(string $title, bool $appendDefault = true)
 * @method static \Turahe\SEOTools\Contracts\Tools setDescription(string $description)
 * @method static \Turahe\SEOTools\Contracts\Tools setCanonical(string $url)
 * @method static \Turahe\SEOTools\Contracts\Tools addImages(array $urls)
 * @method static string getTitle(bool $session = false)
 */
class Tools extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools';
    }
}
