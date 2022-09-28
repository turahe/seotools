<?php
namespace Turahe\SEOTools;

use Turahe\SEOTools\Contracts\JsonLd as JsonLdContract;

/**
 * JsonLd provides implementation for `JsonLd` contract.
 *
 * @see \Turahe\SEOTools\Contracts\JsonLd
 */
class JsonLd implements JsonLdContract
{
    /**
     * @var array
     */
    protected array $values = [];
    /**
     * @var string
     */
    protected string $type = '';
    /**
     * @var string
     */
    protected string $title = '';
    /**
     * @var string
     */
    protected string $description = '';
    /**
     * @var string|null|bool
     */
    protected bool $url = false;
    /**
     * @var array
     */
    protected array $images = [];

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        if (key_exists('title', $defaults)) {
            $this->setTitle($defaults['title']);
            unset($defaults['title']);
        }

        if (key_exists('description', $defaults)) {
            $this->setDescription($defaults['description']);
            unset($defaults['description']);
        }

        if (key_exists('type', $defaults)) {
            $this->setType($defaults['type']);
            unset($defaults['type']);
        }

        if (key_exists('url', $defaults)) {
            $this->setUrl($defaults['url']);
            unset($defaults['url']);
        }

        if (key_exists('images', $defaults)) {
            $this->setImages($defaults['images']);
            unset($defaults['images']);
        }

        $this->values = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return empty($this->values)
            && empty($this->type)
            && empty($this->title)
            && empty($this->description)
            && empty($this->url)
            && empty($this->images);
    }

    /**
     * {@inheritdoc}
     */
    public function generate(bool $minify = false): string
    {
        $generated = array_merge(
            [
                '@context' => 'https://schema.org',
            ],
            $this->convertToArray()
        );

        return '<script type="application/ld+json">' . json_encode($generated, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    /**
     * @return string[]|string[][]
     */
    public function convertToArray(): array
    {
        $generated = [];

        if (! empty($this->type)) {
            $generated['@type'] = $this->type;
        }

        if (! empty($this->title)) {
            $generated['name'] = $this->title;
        }

        if (! empty($this->description)) {
            $generated['description'] = $this->description;
        }

        if ($this->url !== false) {
            $generated['url'] = $this->url ?? app('url')->full();
        }

        if (! empty($this->images)) {
            $generated['image'] = count($this->images) === 1 ? reset($this->images) : $this->images;
        }

        return self::convertSelfObjectInArray(array_merge($generated, $this->values));
    }

    /**
     * @param mixed[] $values
     *
     * @return string[]|string[][]
     */
    private static function convertSelfObjectInArray(array $values): array
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $values[$key] = self::convertSelfObjectInArray($value);

                continue;
            }

            if ($value instanceof self) {
                $values[$key] = $value->convertToArray();
            }
        }

        return $values;
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
    public function addValues(array $values)
    {
        foreach ($values as $key => $value) {
            $this->addValue($key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSite(string $site)
    {
        $this->url = $site;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     *{@inheritdoc}
     */
    public function setUrl(bool|string|null $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setImages(array|string $images)
    {
        $this->images = [];

        return $this->addImage($images);
    }

    /**
     * {@inheritdoc}
     */
    public function addImage(array|string $image)
    {
        if (is_array($image)) {
            $this->images = array_merge($this->images, $image);
        } elseif (is_string($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    /**
     * @param array|string $image
     *
     * @return static
     */
    public function setImage(array|string $image)
    {
        $this->images = [$image];

        return $this;
    }
}
