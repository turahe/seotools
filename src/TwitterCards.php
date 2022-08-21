<?php
namespace Turahe\SEOTools;

use Turahe\SEOTools\Contracts\TwitterCards as TwitterCardsContract;

/**
 * TwitterCards provides implementation for `TwitterCards` contract.
 *
 * @see \Turahe\SEOTools\Contracts\TwitterCards
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

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->values = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(bool $minify = false)
    {
        $this->eachValue($this->values);
        $this->eachValue($this->images, 'images');

        return ($minify) ? implode('', $this->html) : implode(PHP_EOL, $this->html);
    }

    /**
     * Make tags.
     *
     * @param array       $values
     * @param null|string $prefix
     *
     * @internal param array $properties
     */
    protected function eachValue(array $values, $prefix = null)
    {
        foreach ($values as $key => $value):
            if (is_array($value)):
                $this->eachValue($value, $key); else:
                    if (is_numeric($key)):
                        $key = $prefix.$key; elseif (is_string($prefix)):
                            $key = $prefix.':'.$key;
                        endif;

            $this->html[] = $this->makeTag($key, $value);
            endif;
        endforeach;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return string
     *
     * @internal param string $values
     */
    private function makeTag($key, $value)
    {
        $value = str_replace(['http-equiv=', 'url='], '', $value);

        return '<meta name="'.$this->prefix.strip_tags($key).'" content="'.strip_tags($value).'" />';
    }

    /**
     * {@inheritdoc}
     */
    public function addValue(string $key, array|string $value)
    {
        $this->values[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title)
    {
        return $this->addValue('title', $title);
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type)
    {
        return $this->addValue('card', $type);
    }

    /**
     * {@inheritdoc}
     */
    public function setSite(string $site)
    {
        return $this->addValue('site', $site);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description)
    {
        return $this->addValue('description', htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false));
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl(string $url)
    {
        return $this->addValue('url', $url);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated use setImage($image) instead
     */
    public function addImage(array|string $image)
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
    public function setImages(array|string $images)
    {
        $this->images = [];

        return $this->addImage($images);
    }

    /**
     * @param array|string $image
     * @return TwitterCardsContract
     */
    public function setImage(array|string $image)
    {
        return $this->addValue('image', $image);
    }
}
