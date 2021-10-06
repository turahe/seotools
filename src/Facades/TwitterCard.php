<?php

namespace Turahe\Metatags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * TwitterCard is a facade for the `TwitterCards` implementation access.
 *
 * @see \Turahe\Metatags\Contracts\TwitterCards
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\Metatags\Contracts\TwitterCards addValue(string $key, array|string $value)
 * @method static \Turahe\Metatags\Contracts\TwitterCards setType(string $type)
 * @method static \Turahe\Metatags\Contracts\TwitterCards setTitle(string $title)
 * @method static \Turahe\Metatags\Contracts\TwitterCards setSite(string $site)
 * @method static \Turahe\Metatags\Contracts\TwitterCards setDescription(string $description)
 * @method static \Turahe\Metatags\Contracts\TwitterCards setUrl(string $url)
 * @method static \Turahe\Metatags\Contracts\TwitterCards addImage(string|array $image)
 * @method static \Turahe\Metatags\Contracts\TwitterCards setImages(array $images)
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
