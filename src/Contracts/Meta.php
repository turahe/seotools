<?php
namespace Turahe\SEOTools\Contracts;

/**
 * Meta defines contract for the HTML meta tags container.
 *
 * Meta tags container allows specification and rendering of HTML page title and meta tags.
 *
 * Usage example:
 *
 * ```php
 * use Turahe\Tools\Meta; // implements `Turahe\Tools\Contracts\Meta`
 *
 * $metaTags = new Meta();
 *
 * // specify meta info
 * $metaTags->setTitle('Home');
 * $metaTags->setDescription('This is my page description');
 * $metaTags->setCanonical('https://codecasts.com.br/lesson');
 * $metaTags->addMeta('author', 'John Doe');
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $metaTags->generate();
 * ```
 *
 * Implementation of this contract is available via {@see \Turahe\SEOTools\Facades\Meta} facade.
 * Facade usage example:
 *
 * ```php
 * use Turahe\Tools\Facades\Meta;
 *
 * // specify meta info
 * Meta::setTitle('Home');
 * Meta::setDescription('This is my page description');
 * Meta::setCanonical('https://codecasts.com.br/lesson');
 * Meta::addMeta('author', 'John Doe');
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo Meta::generate();
 * ```
 *
 * @see https://www.w3schools.com/tags/tag_meta.asp
 * @see \Turahe\SEOTools\Meta
 * @see \Turahe\SEOTools\Facades\Meta
 */
interface Meta
{
    /**
     * Configuration.
     *
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * Generates meta tags HTML.
     *
     * @param bool $minify
     *
     * @return string
     */
    public function generate(bool $minify = false): string;

    /**
     * Set the title.
     *
     * @param string $title
     * @param bool $appendDefault
     *
     * @return static
     */
    public function setTitle(string $title, bool $appendDefault = true): self;

    /**
     * Sets the default title tag.
     *
     * @param string $default
     *
     * @return static
     */
    public function setTitleDefault(string $default): self;

    /**
     * Set the title separator.
     *
     * @param string $separator
     *
     * @return static
     */
    public function setTitleSeparator(string $separator): self;

    /**
     * Set the description.
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription(string $description): self;

    /**
     * Sets the list of keywords, you can send an array or string separated with commas
     * also clears the previously set keywords.
     *
     * @param array|string $keywords
     *
     * @return static
     */
    public function setKeywords(array|string $keywords): self;

    /**
     * Add a keyword.
     *
     * @param array|string $keyword
     *
     * @return static
     */
    public function addKeyword(array|string $keyword): self;

    /**
     * Remove a metatag.
     *
     * @param string $key
     *
     * @return static
     */
    public function removeMeta(string $key): self;

    /**
     * Add a custom meta tag.
     *
     * @param array|string $meta
     * @param string|null $value
     * @param string $name
     *
     * @return static
     */
    public function addMeta(array|string $meta, string $value = null, string $name = 'name'): self;

    /**
     * Sets the canonical URL.
     *
     * @param string $url
     *
     * @return static
     */
    public function setCanonical(string $url): self;

    /**
     * Sets the prev URL.
     *
     * @param string $url
     *
     * @return static
     */
    public function setPrev(string $url): self;

    /**
     * Sets the next URL.
     *
     * @param string $url
     *
     * @return static
     */
    public function setNext(string $url): self;

    /**
     * Add an alternate language.
     *
     * @param string $lang language code in format ISO 639-1
     * @param string $url
     *
     * @return static
     */
    public function addAlternateLanguage(string $lang, string $url): self;

    /**
     * Add alternate languages.
     *
     * @param array $languages
     *
     * @return static
     */
    public function addAlternateLanguages(array $languages): self;

    /**
     * Get the title formatted for display.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get the title that was set.
     *
     * @return string
     */
    public function getTitleSession(): string;

    /**
     * Get the title separator that was set.
     *
     * @return string
     */
    public function getTitleSeparator(): string;

    /**
     * Get all metatags.
     *
     * @return array
     */
    public function getMetatags(): array;

    /**
     * Get the Meta keywords.
     *
     * @return array
     */
    public function getKeywords(): array;

    /**
     * Get the Meta description.
     *
     * @return string|null
     */
    public function getDescription(): null|string;

    /**
     * Get the canonical URL.
     *
     * @return string
     */
    public function getCanonical(): string;

    /**
     * Get the prev URL.
     *
     * @return string
     */
    public function getPrev(): ?string;

    /**
     * Get the next URL.
     *
     * @return string
     */
    public function getNext(): ?string;

    /**
     * Get alternate languages.
     *
     * @return array
     */
    public function getAlternateLanguages(): array;

    /**
     * Takes the default title.
     *
     * @return string
     */
    public function getDefaultTitle(): string;

    /**
     * Reset all data.
     *
     * @return void
     */
    public function reset();
}
