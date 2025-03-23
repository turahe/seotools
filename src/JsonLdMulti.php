<?php

namespace Turahe\SEOTools;

use Turahe\SEOTools\Contracts\JsonLdMulti as JsonLdMultiContract;

/**
 * JsonLdMulti provides implementation for `JsonLdMulti` contract.
 *
 * @see JsonLdMultiContract
 */
class JsonLdMulti implements JsonLdMultiContract
{
    /**
     * Index of the targeted JsonLd group
     */
    protected int $index = 0;

    /**
     * List of the JsonLd groups
     */
    protected array $list = [];

    protected array $defaultJsonLdData = [];

    /**
     * JsonLdMulti constructor.
     */
    public function __construct(array $defaultJsonLdData = [])
    {
        $this->defaultJsonLdData = $defaultJsonLdData;

        // init the first JsonLd group
        if (empty($this->list)) {
            $this->newJsonLd();
        }
    }

    public function generate(bool $minify = false): string
    {
        if (count($this->list) > 1) {
            return array_reduce($this->list, function (string $output, JsonLd $jsonLd) {
                return $output.(! $jsonLd->isEmpty() ? $jsonLd->generate() : '');
            }, '');
        }

        return false;
    }

    public function newJsonLd(): static
    {
        $this->index = count($this->list);
        $this->list[] = new JsonLd($this->defaultJsonLdData);

        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->list[$this->index]->isEmpty();
    }

    public function select(int $index): static
    {
        // don't change the index if the new one doesn't exists
        if (array_key_exists($this->index, $this->list)) {
            $this->index = $index;
        }

        return $this;
    }

    public function addValue(string $key, array|string $value): static
    {
        $this->list[$this->index]->addValue($key, $value);

        return $this;
    }

    public function addValues(array $values): static
    {
        $this->list[$this->index]->addValues($values);

        return $this;
    }

    public function setType(string $type): static
    {
        $this->list[$this->index]->setType($type);

        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->list[$this->index]->setTitle($title);

        return $this;
    }

    public function setSite(string $site): static
    {
        $this->list[$this->index]->setSite($site);

        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->list[$this->index]->setDescription($description);

        return $this;
    }

    public function setUrl(bool|string|null $url): static
    {
        $this->list[$this->index]->setUrl($url);

        return $this;
    }

    public function setImages(array|string $images): static
    {
        $this->list[$this->index]->setImages($images);

        return $this;
    }

    public function addImage(array|string $image): static
    {
        $this->list[$this->index]->addImage($image);

        return $this;
    }

    public function setImage($image)
    {
        $this->list[$this->index]->setImage($image);

        return $this;
    }
}
