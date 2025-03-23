<?php

namespace Turahe\SEOTools\Contracts;

/**
 * Tools defines contract for the SEO tools aggregator.
 *
 * Such aggregator allows quick setup of meta information over all available containers.
 *
 * Usage example:
 *
 * ```php
 * use Turahe\Tools\Tools; // implements `Turahe\Tools\Contracts\Tools`
 *
 * $seoTools = new Tools();
 *
 * // specify meta info
 * $seoTools->setTitle('Home');
 * $seoTools->setDescription('This is my page description');
 *
 * // access particular container
 * $seoTools->metatags()->addMeta('author', 'John Doe');
 * $seoTools->opengraph()->addProperty('type', 'articles');
 * $seoTools->twitter()->addValue('app:country', 'US');
 * $seoTools->jsonLd()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 * $seoTools->jsonLdMulti()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $seoTools->generate();
 * ```
 *
 * Implementation of this contract is available via {@see \Turahe\SEOTools\Facades\Tools} facade.
 * Facade usage example:
 *
 * ```php
 * use Turahe\Tools\Facades\Tools;
 *
 * // specify meta info
 * Tools::setTitle('Homepage');
 * Tools::setDescription('This is my page description');
 *
 * // access particular container
 * Tools::metatags()->addMeta('author', 'John Doe');
 * Tools::opengraph()->addProperty('type', 'articles');
 * Tools::twitter()->addValue('app:country', 'US');
 * Tools::jsonLd()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 * Tools::jsonLdMulti()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo Tools::generate();
 * ```
 *
 * @see Meta
 * @see OpenGraph
 * @see TwitterCards
 * @see JsonLd
 * @see JsonLdMulti
 *
 * @author `Nur Wachid`
 */
interface Tools
{
    /**
     * @return Meta
     */
    public function metatags();

    /**
     * @return OpenGraph
     */
    public function opengraph();

    /**
     * @return TwitterCards
     */
    public function twitter();

    /**
     * @return JsonLd
     */
    public function jsonLd();

    /**
     * @return JsonLdMulti
     */
    public function jsonLdMulti();

    /**
     * Setup title for all seo providers.
     *
     *
     * @return static
     */
    public function setTitle(string $title, bool $appendDefault = true): self;

    /**
     * Setup description for all seo providers.
     *
     *
     * @return static
     */
    public function setDescription(string $description): self;

    /**
     * Sets the canonical URL.
     *
     *
     * @return static
     */
    public function setCanonical(string $url): self;

    /**
     * Add one or more images urls.
     *
     * @param  array|string  $urls
     * @return static
     */
    public function addImages($urls): self;

    /**
     * Get current title from metatags.
     */
    public function getTitle(bool $session = false): string;

    /**
     * Generate from all seo providers.
     */
    public function generate(bool $minify = false): string;
}
