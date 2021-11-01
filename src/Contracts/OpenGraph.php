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
     * @param array $config
     * @return void
     */
    public function __construct(array $config = []);

    /**
     * Generates open graph tags.
     *
     * @param bool $minify
     *
     * @return string
     */
    public function generate(bool $minify = false): string;

    /**
     * Add or update property.
     *
     * @param string       $key
     * @param string|array $value
     *
     * @return static
     */
    public function addProperty(string $key, $value) :self;

    /**
     * Remove property.
     *
     * @param string $key
     *
     * @return static
     */
    public function removeProperty(string $key): self;

    /**
     * Add image to properties.
     *
     * @param string $url
     * @param array  $attributes
     *
     * @return static
     */
    public function addImage(string $url, array $attributes = []): self;

    /**
     * Add images to properties.
     *
     * @param array $urls
     *
     * @return static
     */
    public function addImages(array $urls): self;

    /**
     * Define title property.
     *
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title): self;

    /**
     * Define description property.
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription(string $description):self;

    /**
     * Define url property.
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl(string $url): self;

    /**
     * Define site_name property.
     *
     * @param string $name
     *
     * @return static
     */
    public function setSiteName(string $name): self;

    /**
     * Define type property.
     *
     * @param string|null $type set the opengraph type
     *
     * @return static
     */
    public function setType(string $type = null): self;

    /**
     * Set Article properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setArticle(array $attributes = []): self;

    /**
     * Set Profile properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setProfile(array $attributes = []): self;

    /**
     * Set Music Song properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setMusicSong(array $attributes = []): self;

    /**
     * Set Music Album properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setMusicAlbum(array $attributes = []): self;

    /**
     * Set Music Playlist properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setMusicPlaylist(array $attributes = []): self;

    /**
     * Set Music  RadioStation properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setMusicRadioStation(array $attributes = []): self;

    /**
     * Set Video Movie properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setVideoMovie(array $attributes = []): self;

    /**
     * Set Video Episode properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setVideoEpisode(array $attributes = []): self;

    /**
     * Set Video Episode properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setVideoOther(array $attributes = []): self;

    /**
     * Set Video Episode properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setVideoTVShow(array $attributes = []): self;

    /**
     * Set Book properties.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setBook(array $attributes = []): self;

    /**
     * Add Video properties.
     *
     * @param string|null $source
     * @param array $attributes
     *
     * @return static
     */
    public function addVideo(string $source = null, array $attributes = []): self;

    /**
     * Add audio properties.
     *
     * @param string|null $source
     * @param array $attributes
     *
     * @return static
     */
    public function addAudio(string $source = null, array $attributes = []): self;
}
