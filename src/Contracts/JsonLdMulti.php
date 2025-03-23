<?php

namespace Turahe\SEOTools\Contracts;

/**
 * JsonLdMulti defines contract for the JSON Linked Data container.
 * Usage example:
 * ```php
 * use Turahe\Tools\JsonLdMulti; // implements `Turahe\Tools\Contracts\JsonLdMulti`
 * $jsonLdMulti = new JsonLdMulti();
 * // specify JSON data
 * $jsonLdMulti->setTitle('Home');
 * $jsonLdMulti->setDescription('This is my page description');
 * $jsonLdMulti->addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 * $jsonLdMulti->newJsonLd();
 * $jsonLdMulti->setTitle('Homepage');
 * $jsonLdMulti->setType('Product');
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $jsonLd->generate();
 * ```
 * Implementation of this contract is available via {@see \Turahe\SEOTools\Facades\JsonLdMulti} facade.
 * Facade usage example:
 * ```php
 * use Turahe\Tools\Facades\JsonLdMulti;
 * // specify JSON data
 * JsonLdMulti::setTitle('Home');
 * JsonLdMulti::setDescription('This is my page description');
 * JsonLdMulti::addValue('author', [
 *     '@type' => 'Organization',
 *     'name' => 'Turahe',
 * ]));
 * JsonLdMulti::newJsonLd();
 * JsonLdMulti::setTitle('Homepage');
 * JsonLdMulti::setType('Product');
 * // render HTML, it should be placed within 'head' HTML tag
 * echo JsonLdMulti::generate();
 * ```
 *
 * @see https://json-ld.org/
 * @see \Turahe\SEOTools\JsonLdMulti
 * @see \Turahe\SEOTools\Facades\JsonLdMulti
 */
interface JsonLdMulti
{
    /**
     * JsonLdMulti constructor.
     */
    public function __construct(array $defaultJsonLdData = []);

    /**
     * Generates linked data script tag.
     */
    public function generate(bool $minify = false): string;

    /**
     * Create a new JsonLd group and increment the selector to target it
     */
    public function newJsonLd(): static;

    /**
     *  Check if the current JsonLd group is empty
     */
    public function isEmpty(): bool;

    /**
     * Target a JsonLd group that will be edited in the next methods
     */
    public function select(int $index): static;

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
