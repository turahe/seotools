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
    public function __construct(array $defaults = []);

    /**
     * Generates linked data script tag.
     */
    public function generate(bool $minify = false): string;

    /**
     *  Check if all attribute are empty
     */
    public function isEmpty(): bool;

    public function addValue(string $key, array|string $value): static;

    public function addValues(array $values): static;

    public function setType(string $type): static;

    public function setTitle(string $title): static;

    public function setSite(string $site): static;

    public function setDescription(string $description): static;

    public function setUrl(bool|string|null $url): static;

    public function addImage(array|string $image): static;

    public function setImages(array|string $images): static;
}
