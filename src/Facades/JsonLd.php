<?php

namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JsonLd is a facade for the `JsonLd` implementation access.
 *
 * @see \Turahe\SEOTools\Contracts\JsonLd
 * @method static string generate(bool $minify = false)
 * @method static bool isEmpty()
 * @method static \Turahe\SEOTools\Contracts\JsonLd addValue(string $key, array|string $value)
 * @method static \Turahe\SEOTools\Contracts\JsonLd addValues(array $values)
 * @method static \Turahe\SEOTools\Contracts\JsonLd setType(string $type)
 * @method static \Turahe\SEOTools\Contracts\JsonLd setTitle(string $title)
 * @method static \Turahe\SEOTools\Contracts\JsonLd setSite(string $site)
 * @method static \Turahe\SEOTools\Contracts\JsonLd setDescription(string $description)
 * @method static \Turahe\SEOTools\Contracts\JsonLd setUrl(string $url)
 * @method static \Turahe\SEOTools\Contracts\JsonLd addImage(array|string $image)
 * @method static \Turahe\SEOTools\Contracts\JsonLd setImages(array $images)
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
