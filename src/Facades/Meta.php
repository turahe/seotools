<?php

namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Meta is a facade for the `Meta` implementation access.
 *
 * @see \Turahe\SEOTools\Contracts\Meta
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\SEOTools\Contracts\Meta setTitle(string $title, bool $appendDefault = true)
 * @method static \Turahe\SEOTools\Contracts\Meta setTitleDefault(string $default)
 * @method static \Turahe\SEOTools\Contracts\Meta setTitleSeparator(string $separator)
 * @method static \Turahe\SEOTools\Contracts\Meta setDescription(string $description)
 * @method static \Turahe\SEOTools\Contracts\Meta setKeywords(array|string $keywords)
 * @method static \Turahe\SEOTools\Contracts\Meta addKeyword(string $keyword)
 * @method static \Turahe\SEOTools\Contracts\Meta removeMeta(string $key)
 * @method static \Turahe\SEOTools\Contracts\Meta addMeta(array|string $meta, string|null $value = null, string $name = 'name')
 * @method static \Turahe\SEOTools\Contracts\Meta setCanonical(string $url)
 * @method static \Turahe\SEOTools\Contracts\Meta setPrev(string $url)
 * @method static \Turahe\SEOTools\Contracts\Meta setNext(string $url)
 * @method static \Turahe\SEOTools\Contracts\Meta addAlternateLanguage(string $lang, string $url)
 * @method static \Turahe\SEOTools\Contracts\Meta addAlternateLanguages(array $languages)
 * @method static string getTitle()
 * @method static string getTitleSession()
 * @method static string getTitleSeparator()
 * @method static array getMetatags()
 * @method static array getKeywords()
 * @method static string|null getDescription()
 * @method static string getCanonical()
 * @method static string getPrev()
 * @method static string getNext()
 * @method static string getAlternateLanguages()
 * @method static string getDefaultTitle()
 * @method static void reset()
 */
class Meta extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools.metatags';
    }
}
