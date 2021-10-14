<?php

namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JsonLd is a facade for the `JsonLd` implementation access.
 *
 * @see \Turahe\SEOTools\Contracts\JsonLdMulti
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti newJsonLd()
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti isEmpty()
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti select(int $index)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti addValue(string $key, array|string $value)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti addValues(array $values)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti setType(string $type)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti setTitle(string $title)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti setSite(string $site)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti setDescription(string $description)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti setUrl(string $url)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti addImage(array|string $image)
 * @method static \Turahe\SEOTools\Contracts\JsonLdMulti setImages(array $images)
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
