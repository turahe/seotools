<?php

namespace Turahe\Metatags\Contracts;

/**
 * SEOTools defines contract for the SEO tools aggregator.
 *
 * Such aggregator allows quick setup of meta information over all available containers.
 *
 * Usage example:
 *
 * ```php
 * use Turahe\Metatags\SEOTools; // implements `Turahe\Metatags\Contracts\SEOTools`
 *
 * $seoTools = new SEOTools();
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
 *     'name' => 'Artesaos',
 * ]));
 * $seoTools->jsonLdMulti()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Artesaos',
 * ]));
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $seoTools->generate();
 * ```
 *
 * Implementation of this contract is available via {@see \Turahe\Metatags\Facades\SEOTools} facade.
 * Facade usage example:
 *
 * ```php
 * use Turahe\Metatags\Facades\SEOTools;
 *
 * // specify meta info
 * SEOTools::setTitle('Homepage');
 * SEOTools::setDescription('This is my page description');
 *
 * // access particular container
 * SEOTools::metatags()->addMeta('author', 'John Doe');
 * SEOTools::opengraph()->addProperty('type', 'articles');
 * SEOTools::twitter()->addValue('app:country', 'US');
 * SEOTools::jsonLd()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Artesaos',
 * ]));
 * SEOTools::jsonLdMulti()->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Artesaos',
 * ]));
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo SEOTools::generate();
 * ```
 *
 * @see \Turahe\Metatags\Contracts\MetaTags
 * @see \Turahe\Metatags\Contracts\OpenGraph
 * @see \Turahe\Metatags\Contracts\TwitterCards
 * @see \Turahe\Metatags\Contracts\JsonLd
 * @see \Turahe\Metatags\Contracts\JsonLdMulti
 *
 * @author `Vinicius Reis`
 */
interface SEOTools
{
    /**
     * @return \Turahe\Metatags\Contracts\MetaTags
     */
    public function metatags();

    /**
     * @return \Turahe\Metatags\Contracts\OpenGraph
     */
    public function opengraph();

    /**
     * @return \Turahe\Metatags\Contracts\TwitterCards
     */
    public function twitter();

    /**
     * @return \Turahe\Metatags\Contracts\JsonLd
     */
    public function jsonLd();

    /**
     * @return \Turahe\Metatags\Contracts\JsonLdMulti
     */
    public function jsonLdMulti();

    /**
     * Setup title for all seo providers.
     *
     * @param string $title
     * @param bool   $appendDefault
     *
     * @return static
     */
    public function setTitle($title, $appendDefault = true);

    /**
     * Setup description for all seo providers.
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription($description);

    /**
     * Sets the canonical URL.
     *
     * @param string $url
     *
     * @return static
     */
    public function setCanonical($url);

    /**
     * Add one or more images urls.
     *
     * @param array|string $urls
     *
     * @return static
     */
    public function addImages($urls);

    /**
     * Get current title from metatags.
     *
     * @param bool $session
     *
     * @return string
     */
    public function getTitle($session = false);

    /**
     * Generate from all seo providers.
     *
     * @param bool $minify
     *
     * @return string
     */
    public function generate($minify = false);
}
