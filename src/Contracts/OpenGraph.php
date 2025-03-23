<?php

namespace Turahe\SEOTools\Contracts;

/**
 * OpenGraph defines contract for the "OpenGraph" meta tags container.
 *
 * "OpenGraph" meta tags are widely used among social networks like Facebook during the "sharing" process.
 *
 * Usage example:
 *
 * ```php
 * use Turahe\Tools\OpenGraph; // implements `Turahe\Tools\Contracts\OpenGraph`
 *
 * $openGraph = new OpenGraph();
 *
 * // specify meta info
 * $openGraph->setTitle('Home');
 * $openGraph->setDescription('This is my page description');
 * $openGraph->setUrl('http://current.url.com');
 * $openGraph->addProperty('type', 'articles');
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $openGraph->generate();
 * ```
 *
 * Implementation of this contract is available via {@see \Turahe\SEOTools\Facades\OpenGraph} facade.
 * Facade usage example:
 *
 * ```php
 * use Turahe\Tools\Facades\OpenGraph;
 *
 * // specify meta info
 * OpenGraph::setTitle('Home');
 * OpenGraph::setDescription('This is my page description');
 * OpenGraph::setUrl('http://current.url.com');
 * OpenGraph::addProperty('type', 'articles');
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo OpenGraph::generate();
 * ```
 *
 * > Attention: namespace 'http://ogp.me/ns#' should appear at the HTML declaration tag in order for the "OpenGraph" tags
 *   be recognized properly. You'll have to do this manually, so your HTML page structure should look like following:
 *
 * ```html
 * <html prefix="og: http://ogp.me/ns#">
 * <head>
 * <title>...</title>
 * ...
 * </head>
 * ...
 * </html>
 * ```
 *
 * @see https://ogp.me/
 * @see \Turahe\SEOTools\OpenGraph
 * @see \Turahe\SEOTools\Facades\OpenGraph
 */
interface OpenGraph
{
    /**
     * @return void
     */
    public function __construct(array $config = []);

    /**
     * Generates open graph tags.
     */
    public function generate(bool $minify = false): string;

    /**
     * Add or update property.
     *
     *
     * @return static
     */
    public function addProperty(string $key, array|string $value): self;

    /**
     * Remove property.
     *
     *
     * @return static
     */
    public function removeProperty(string $key): self;

    /**
     * Add image to properties.
     *
     *
     * @return static
     */
    public function addImage(string $url, array $attributes = []): self;

    /**
     * Add images to properties.
     *
     *
     * @return static
     */
    public function addImages(array $urls): self;

    /**
     * Define title property.
     *
     *
     * @return static
     */
    public function setTitle(string $title): self;

    /**
     * Define description property.
     *
     *
     * @return static
     */
    public function setDescription(string $description): self;

    /**
     * Define url property.
     *
     *
     * @return static
     */
    public function setUrl(string $url): self;

    /**
     * Define site_name property.
     *
     *
     * @return static
     */
    public function setSiteName(string $name): self;

    /**
     * Define type property.
     *
     * @param  string|null  $type  set the opengraph type
     * @return static
     */
    public function setType(?string $type = null): self;

    /**
     * Set Article properties.
     *
     *
     * @return static
     */
    public function setArticle(array $attributes = []): self;

    /**
     * Set Profile properties.
     *
     *
     * @return static
     */
    public function setProfile(array $attributes = []): self;

    /**
     * Set Music Song properties.
     *
     *
     * @return static
     */
    public function setMusicSong(array $attributes = []): self;

    /**
     * Set Music Album properties.
     *
     *
     * @return static
     */
    public function setMusicAlbum(array $attributes = []): self;

    /**
     * Set Music Playlist properties.
     *
     *
     * @return static
     */
    public function setMusicPlaylist(array $attributes = []): self;

    /**
     * Set Music  RadioStation properties.
     *
     *
     * @return static
     */
    public function setMusicRadioStation(array $attributes = []): self;

    /**
     * Set Video Movie properties.
     *
     *
     * @return static
     */
    public function setVideoMovie(array $attributes = []): self;

    /**
     * Set Video Episode properties.
     *
     *
     * @return static
     */
    public function setVideoEpisode(array $attributes = []): self;

    /**
     * Set Video Episode properties.
     *
     *
     * @return static
     */
    public function setVideoOther(array $attributes = []): self;

    /**
     * Set Video Episode properties.
     *
     *
     * @return static
     */
    public function setVideoTVShow(array $attributes = []): self;

    /**
     * Set Book properties.
     *
     *
     * @return static
     */
    public function setBook(array $attributes = []): self;

    /**
     * Add Video properties.
     *
     *
     * @return static
     */
    public function addVideo(?string $source = null, array $attributes = []): self;

    /**
     * Add audio properties.
     *
     *
     * @return static
     */
    public function addAudio(?string $source = null, array $attributes = []): self;
}
