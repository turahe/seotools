<?php

namespace Turahe\SEOTools;

use Turahe\SEOTools\Contracts\TwitterCards as TwitterCardsContract;

/**
 * TwitterCards provides implementation for `TwitterCards` contract.
 *
 * @see TwitterCardsContract
 */
class TwitterCards implements TwitterCardsContract
{
    /**
     * @var string
     */
    protected $prefix = 'twitter:';

    /**
     * @var array
     */
    protected $html = [];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $images = [];

    public function __construct(array $defaults = [])
    {
        $this->values = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(bool $minify = false): string
    {
        $this->eachValue($this->values);
        $this->eachValue($this->images, 'images');

        return ($minify) ? implode('', $this->html) : implode(PHP_EOL, $this->html);
    }

    /**
     * Make tags.
     *
     *
     * @internal param array $properties
     */
    protected function eachValue(array $values, ?string $prefix = null)
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $this->eachValue($value, $key);
            } else {
                if (is_numeric($key)) {
                    $key = $prefix.$key;
                } elseif (is_string($prefix)) {
                    $key = $prefix.':'.$key;
                }

                $this->html[] = $this->makeTag($key, $value);
            }
        }
    }

    /**
     * @internal param string $values
     */
    private function makeTag(string $key, $value): string
    {
        $value = str_replace(['http-equiv=', 'url='], '', $value);

        return '<meta name="'.$this->prefix.strip_tags($key).'" content="'.strip_tags($value).'" />';
    }

    /**
     * {@inheritdoc}
     */
    public function addValue(string $key, array|string $value): static
    {
        $this->values[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title): static
    {
        return $this->addValue('title', $title);
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type): static
    {
        return $this->addValue('card', $type);
    }

    /**
     * {@inheritdoc}
     */
    public function setSite(string $site): static
    {
        return $this->addValue('site', $site);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description): static
    {
        return $this->addValue('description', htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false));
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl(string $url): static
    {
        return $this->addValue('url', $url);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated use setImage($image) instead
     */
    public function addImage(array|string $image): static
    {
        foreach ((array) $image as $url) {
            $this->images[] = $url;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated use setImage($image) instead
     */
    public function setImages(array|string $images): static
    {
        $this->images = [];

        return $this->addImage($images);
    }

    /**
     * @return TwitterCardsContract
     */
    public function setImage(array|string $image): static
    {
        return $this->addValue('image', $image);
    }
}
