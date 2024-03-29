<?php
namespace Turahe\SEOTools\Contracts;

/**
 * JsonLd defines contract for the JSON Linked Data container.
 *
 * Usage example:
 *
 * ```php
 * use Turahe\Tools\JsonLd; // implements `Turahe\Tools\Contracts\JsonLd`
 *
 * $jsonLd = new JsonLd();
 *
 * // specify JSON data
 * $jsonLd->setTitle('Home');
 * $jsonLd->setDescription('This is my page description');
 * $jsonLd->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $jsonLd->generate();
 * ```
 *
 * Implementation of this contract is available via {@see \Turahe\SEOTools\Facades\JsonLd} facade.
 * Facade usage example:
 *
 * ```php
 * use Turahe\Tools\Facades\JsonLd;
 *
 * // specify JSON data
 * JsonLd::setTitle('Homepage');
 * JsonLd::setDescription('This is my page description');
 * JsonLd::addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo JsonLd::generate();
 * ```
 *
 * @see https://json-ld.org/
 * @see \Turahe\SEOTools\JsonLd
 * @see \Turahe\SEOTools\Facades\JsonLd
 */
interface JsonLd
{
    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = []);

    /**
     * Generates linked data script tag.
     *
     * @param bool $minify
     *
     * @return string
     */
    public function generate(bool $minify = false);

    /**
     *  Check if all attribute are empty
     *
     * @return static
     */
    public function isEmpty();

    /**
     * @param string $key
     * @param array|string $value
     *
     * @return static
     */
    public function addValue(string $key, array|string $value);

    /**
     * @param array $values
     *
     * @return static
     */
    public function addValues(array $values);

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType(string $type);

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title);

    /**
     * @param string $site
     *
     * @return static
     */
    public function setSite(string $site);

    /**
     * @param string $description
     *
     * @return static
     */
    public function setDescription(string $description);

    /**
     * @param bool|string|null $url
     *
     * @return static
     */
    public function setUrl(bool|string|null $url);

    /**
     * @param array|string $image
     *
     * @return static
     */
    public function addImage(array|string $image);

    /**
     * @param array|string $images
     *
     * @return static
     */
    public function setImages(array|string $images);
}
