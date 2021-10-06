<?php

namespace Turahe\Metatags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JsonLd is a facade for the `JsonLd` implementation access.
 *
 * @see \Turahe\Metatags\Contracts\JsonLdMulti
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti newJsonLd()
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti isEmpty()
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti select(int $index)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti addValue(string $key, array|string $value)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti addValues(array $values)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti setType(string $type)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti setTitle(string $title)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti setSite(string $site)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti setDescription(string $description)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti setUrl(string $url)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti addImage(array|string $image)
 * @method static \Turahe\Metatags\Contracts\JsonLdMulti setImages(array $images)
 */
class JsonLdMulti extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools.json-ld-multi';
    }
}
