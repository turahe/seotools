<?php

namespace Turahe\SEOTools\Contracts;

/**
 * TwitterCards defines contract for the "TwitterCard" meta tags container.
 *
 * "TwitterCard" meta tags are used by Twitter during the "sharing" process.
 *
 * Usage example:
 *
 * ```php
 * use Turahe\Tools\TwitterCards; // implements `Turahe\Tools\Contracts\TwitterCards`
 *
 * $twitterCards = new TwitterCards();
 *
 * // specify meta info
 * $twitterCards->setTitle('Home');
 * $twitterCards->setUrl('http://current.url.com');
 * $twitterCards->addValue('app:country', 'US');
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo $twitterCards->generate();
 * ```
 *
 * Implementation of this contract is available via {@see \Turahe\SEOTools\Facades\TwitterCard} facade.
 * Facade usage example:
 *
 * ```php
 * use Turahe\Tools\Facades\TwitterCard;
 *
 * // specify meta info
 * TwitterCard::setTitle('Home');
 * TwitterCard::setUrl('http://current.url.com');
 * TwitterCard::addValue('app:country', 'US');
 *
 * // render HTML, it should be placed within 'head' HTML tag
 * echo TwitterCard::generate();
 * ```
 *
 * @see https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/abouts-cards
 * @see \Turahe\SEOTools\TwitterCards
 * @see \Turahe\SEOTools\Facades\TwitterCard
 */
interface TwitterCards
{
    public function __construct(array $defaults = []);

    public function generate(bool $minify = false): string;

    public function addValue(string $key, array|string $value): static;

    public function setType(string $type): static;

    public function setTitle(string $title): static;

    public function setSite(string $site): static;

    public function setDescription(string $description): static;

    public function setUrl(string $url): static;

    public function addImage(array|string $image): static;

    public function setImages(array|string $images): static;

    public function setImage(array|string $image): static;
}
