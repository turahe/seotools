<?php

namespace Turahe\Metatags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * SEOMeta is a facade for the `MetaTags` implementation access.
 *
 * @see \Turahe\Metatags\Contracts\MetaTags
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\Metatags\Contracts\MetaTags setTitle(string $title, bool $appendDefault = true)
 * @method static \Turahe\Metatags\Contracts\MetaTags setTitleDefault(string $default)
 * @method static \Turahe\Metatags\Contracts\MetaTags setTitleSeparator(string $separator)
 * @method static \Turahe\Metatags\Contracts\MetaTags setDescription(string $description)
 * @method static \Turahe\Metatags\Contracts\MetaTags setKeywords(array|string $keywords)
 * @method static \Turahe\Metatags\Contracts\MetaTags addKeyword(string $keyword)
 * @method static \Turahe\Metatags\Contracts\MetaTags removeMeta(string $key)
 * @method static \Turahe\Metatags\Contracts\MetaTags addMeta(array|string $meta, string|null $value = null, string $name = 'name')
 * @method static \Turahe\Metatags\Contracts\MetaTags setCanonical(string $url)
 * @method static \Turahe\Metatags\Contracts\MetaTags setPrev(string $url)
 * @method static \Turahe\Metatags\Contracts\MetaTags setNext(string $url)
 * @method static \Turahe\Metatags\Contracts\MetaTags addAlternateLanguage(string $lang, string $url)
 * @method static \Turahe\Metatags\Contracts\MetaTags addAlternateLanguages(array $languages)
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
class SEOMeta extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools.metatags';
    }
}
