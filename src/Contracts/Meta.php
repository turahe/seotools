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
     */
    public function __construct(array $config);

    /**
     * Generates meta tags HTML.
     */
    public function generate(bool $minify = false): string;

    /**
     * Set the title.
     *
     *
     * @return static
     */
    public function setTitle(string $title, bool $appendDefault = true): self;

    /**
     * Sets the default title tag.
     *
     *
     * @return static
     */
    public function setTitleDefault(string $default): self;

    /**
     * Set the title separator.
     *
     *
     * @return static
     */
    public function setTitleSeparator(string $separator): self;

    /**
     * Set the description.
     *
     *
     * @return static
     */
    public function setDescription(string $description): self;

    /**
     * Sets the list of keywords, you can send an array or string separated with commas
     * also clears the previously set keywords.
     *
     *
     * @return static
     */
    public function setKeywords(array|string $keywords): self;

    /**
     * Add a keyword.
     *
     *
     * @return static
     */
    public function addKeyword(array|string $keyword): self;

    /**
     * Remove a metatag.
     *
     *
     * @return static
     */
    public function removeMeta(string $key): self;

    /**
     * Add a custom meta tag.
     *
     *
     * @return static
     */
    public function addMeta(array|string $meta, ?string $value = null, string $name = 'name'): self;

    /**
     * Sets the canonical URL.
     *
     *
     * @return static
     */
    public function setCanonical(string $url): self;

    /**
     * Sets the prev URL.
     *
     *
     * @return static
     */
    public function setPrev(string $url): self;

    /**
     * Sets the next URL.
     *
     *
     * @return static
     */
    public function setNext(string $url): self;

    /**
     * Add an alternate language.
     *
     * @param  string  $lang  language code in format ISO 639-1
     * @return static
     */
    public function addAlternateLanguage(string $lang, string $url): self;

    /**
     * Add alternate languages.
     *
     *
     * @return static
     */
    public function addAlternateLanguages(array $languages): self;

    /**
     * Get the title formatted for display.
     */
    public function getTitle(): string;

    /**
     * Get the title that was set.
     */
    public function getTitleSession(): string;

    /**
     * Get the title separator that was set.
     */
    public function getTitleSeparator(): string;

    /**
     * Get all metatags.
     */
    public function getMetatags(): array;

    /**
     * Get the Meta keywords.
     */
    public function getKeywords(): array;

    /**
     * Get the Meta description.
     */
    public function getDescription(): ?string;

    /**
     * Get the canonical URL.
     */
    public function getCanonical(): string;

    /**
     * Get the prev URL.
     */
    public function getPrev(): ?string;

    /**
     * Get the next URL.
     */
    public function getNext(): ?string;

    /**
     * Get alternate languages.
     */
    public function getAlternateLanguages(): array;

    /**
     * Takes the default title.
     */
    public function getDefaultTitle(): string;

    /**
     * Reset all data.
     *
     * @return void
     */
    public function reset();
}
