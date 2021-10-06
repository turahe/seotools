<?php

namespace Turahe\Metatags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JsonLd is a facade for the `JsonLd` implementation access.
 *
 * @see \Turahe\Metatags\Contracts\JsonLd
 * @method static string generate(bool $minify = false)
 * @method static bool isEmpty()
 * @method static \Turahe\Metatags\Contracts\JsonLd addValue(string $key, array|string $value)
 * @method static \Turahe\Metatags\Contracts\JsonLd addValues(array $values)
 * @method static \Turahe\Metatags\Contracts\JsonLd setType(string $type)
 * @method static \Turahe\Metatags\Contracts\JsonLd setTitle(string $title)
 * @method static \Turahe\Metatags\Contracts\JsonLd setSite(string $site)
 * @method static \Turahe\Metatags\Contracts\JsonLd setDescription(string $description)
 * @method static \Turahe\Metatags\Contracts\JsonLd setUrl(string $url)
 * @method static \Turahe\Metatags\Contracts\JsonLd addImage(array|string $image)
 * @method static \Turahe\Metatags\Contracts\JsonLd setImages(array $images)
 */
class JsonLd extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools.json-ld';
    }
}
