<?php

namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * TwitterCard is a facade for the `TwitterCards` implementation access.
 *
 * @see \Turahe\SEOTools\Contracts\TwitterCards
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards addValue(string $key, array|string $value)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards setType(string $type)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards setTitle(string $title)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards setSite(string $site)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards setDescription(string $description)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards setUrl(string $url)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards addImage(string|array $image)
 * @method static \Turahe\SEOTools\Contracts\TwitterCards setImages(array $images)
 */
class TwitterCard extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools.twitter';
    }
}
