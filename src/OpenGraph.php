<?php

namespace Turahe\SEOTools;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Turahe\SEOTools\Contracts\OpenGraph as OpenGraphContract;

/**
 * OpenGraph provides implementation for `OpenGraph` contract.
 *
 * @see OpenGraphContract
 */
class OpenGraph implements OpenGraphContract
{
    /**
     * OpenGraph Prefix.
     */
    protected string $og_prefix = 'og:';

    /**
     * Config.
     */
    protected array $config;

    /**
     * Url property
     */
    protected string $url = '';

    /**
     * Array of Properties.
     */
    protected array $properties = [];

    /**
     * Array of Article Properties.
     */
    protected array $articleProperties = [];

    /**
     * Array of Profile Properties.
     */
    protected array $profileProperties = [];

    /**
     * Array of Music Song Properties.
     */
    protected array $musicSongProperties = [];

    /**
     * Array of Music Album Properties.
     */
    protected array $musicAlbumProperties = [];

    /**
     * Array of Music Playlist Properties.
     */
    protected array $musicPlaylistProperties = [];

    /**
     * Array of Music Radio Properties.
     */
    protected array $musicRadioStationProperties = [];

    /**
     * Array of Video Movie Properties.
     */
    protected array $videoMovieProperties = [];

    /**
     * Array of Video Episode Properties.
     */
    protected array $videoEpisodeProperties = [];

    /**
     * Array of Video TV Show Properties.
     */
    protected array $videoTVShowProperties = [];

    /**
     * Array of Video Other Properties.
     */
    protected array $videoOtherProperties = [];

    /**
     * Array of Book Properties.
     */
    protected array $bookProperties = [];

    /**
     * Array of Video Properties.
     */
    protected array $videoProperties = [];

    /**
     * Array of Audio Properties.
     */
    protected array $audioProperties = [];

    /**
     * Array of Place Properties.
     */
    protected array $placeProperties = [];

    /**
     * Array of Product Properties.
     */
    protected array $productProperties = [];

    /**
     * Array of Image Properties.
     */
    protected array $images = [];

    /**
     * Create a new OpenGraph instance.
     *
     * @param  array  $config  config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($minify = false): string
    {
        $this->setupDefaults();

        $output = $this->eachProperties($this->properties);

        $props = [
            'images' => ['image',   true],
            'articleProperties' => ['article', false],
            'profileProperties' => ['profile', false],
            'bookProperties' => ['book',    false],
            'musicSongProperties' => ['music',   false],
            'musicAlbumProperties' => ['music',   false],
            'musicPlaylistProperties' => ['music',   false],
            'musicRadioStationProperties' => ['music',   false],
            'videoMovieProperties' => ['video',   false],
            'videoEpisodeProperties' => ['video',   false],
            'videoTVShowProperties' => ['video',   false],
            'videoOtherProperties' => ['video',   false],
            'videoProperties' => ['video',   true],
            'audioProperties' => ['audio',   true],
            'placeProperties' => ['place',   false],
            'productProperties' => ['product', false],
        ];

        foreach ($props as $prop => $options) {
            $output .= $this->eachProperties(
                $this->{$prop},
                $options[0],
                $options[1]
            );
        }

        return ($minify) ? str_replace(PHP_EOL, '', $output) : $output;
    }

    /**
     * Make list of open graph tags.
     *
     * @param  array  $properties  array of properties
     * @param  string|null  $prefix  prefix of property
     * @param  bool  $ogPrefix  opengraph prefix
     */
    protected function eachProperties(array $properties, ?string $prefix = null, bool $ogPrefix = true): string
    {
        $html = [];

        foreach ($properties as $property => $value) {
            // multiple properties
            if (is_array($value)) {
                if (is_string($property)) {
                    $subListPrefix = $prefix.':'.$property;
                    $subList = $this->eachProperties($value, $subListPrefix, false);
                } else {
                    $subListPrefix = (is_string($property)) ? $property : $prefix;
                    $subList = $this->eachProperties($value, $subListPrefix);
                }

                $html[] = $subList;
            } else {
                if (is_string($prefix)) {
                    $key = (is_string($property)) ?
                        $prefix.':'.$property :
                        $prefix;
                } else {
                    $key = $property;
                }

                // if empty jump to next
                if (empty($value)) {
                    continue;
                }

                $html[] = $this->makeTag($key, $value, $ogPrefix);
            }
        }

        return implode($html);
    }

    /**
     * Make a og tag.
     *
     * @param  string|null  $key  meta property key
     * @param  string|null  $value  meta property value
     * @param  bool  $ogPrefix  opengraph prefix
     */
    protected function makeTag(?string $key = null, ?string $value = null, bool $ogPrefix = false): string
    {
        $value = str_replace(['http-equiv=', 'url='], '', $value);

        return sprintf(
            '<meta property="%s%s" content="%s" />%s',
            $ogPrefix ? $this->og_prefix : '',
            strip_tags($key),
            strip_tags($value),
            PHP_EOL
        );
    }

    /**
     * Add or update property.
     *
     * @return void
     */
    protected function setupDefaults()
    {
        $defaults = (isset($this->config['defaults'])) ?
            $this->config['defaults'] :
            [];

        foreach ($defaults as $key => $value) {
            if ($key === 'images') {
                if (empty($this->images)) {
                    $this->images = $value;
                }
            } elseif ($key === 'url' && empty($value)) {
                if ($value === null) {
                    $this->addProperty('url', $this->url ?: app('url')->current());
                } elseif ($this->url) {
                    $this->addProperty('url', $this->url);
                }
            } elseif (! empty($value) && ! array_key_exists($key, $this->properties)) {
                $this->addProperty($key, $value);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addProperty($key, array|string $value): self
    {
        $this->properties[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setArticle($attributes = []): self
    {
        $validkeys = [
            'published_time',
            'modified_time',
            'expiration_time',
            'author',
            'section',
            'tag',
        ];

        $this->setProperties(
            'article',
            'articleProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProfile($attributes = []): self
    {
        $validkeys = [
            'first_name',
            'last_name',
            'username',
            'gender',
        ];

        $this->setProperties(
            'profile',
            'profileProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBook($attributes = []): self
    {
        $validkeys = [
            'author',
            'isbn',
            'release_date',
            'tag',
        ];

        $this->setProperties('book', 'bookProperties', $attributes, $validkeys);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicSong($attributes = []): self
    {
        $validkeys = [
            'duration',
            'album',
            'album:disc',
            'album:track',
            'musician',
        ];

        $this->setProperties(
            'music.song',
            'musicSongProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicAlbum($attributes = []): self
    {
        $validkeys = [
            'song',
            'song:disc',
            'song:track',
            'musician',
            'release_date',
        ];

        $this->setProperties(
            'music.album',
            'musicAlbumProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicPlaylist($attributes = []): self
    {
        $validkeys = [
            'song',
            'song:disc',
            'song:track',
            'creator',
        ];

        $this->setProperties(
            'music.playlist',
            'musicPlaylistProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicRadioStation($attributes = []): self
    {
        $validkeys = [
            'creator',
        ];

        $this->setProperties(
            'music.radio_station',
            'musicRadioStationProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setVideoMovie($attributes = []): self
    {
        $validkeys = [
            'actor',
            'actor:role',
            'director',
            'writer',
            'duration',
            'release_date',
            'tag',
        ];

        $this->setProperties(
            'video.movie',
            'videoMovieProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setVideoEpisode($attributes = []): self
    {
        $validkeys = [
            'actor',
            'actor:role',
            'director',
            'writer',
            'duration',
            'release_date',
            'tag',
            'series',
        ];

        $this->setProperties(
            'video.episode',
            'videoEpisodeProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setVideoOther($attributes = []): self
    {
        $validkeys = [
            'actor',
            'actor:role',
            'director',
            'writer',
            'duration',
            'release_date',
            'tag',
        ];

        $this->setProperties(
            'video.other',
            'videoOtherProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setVideoTVShow($attributes = []): self
    {
        $validkeys = [
            'actor',
            'actor:role',
            'director',
            'writer',
            'duration',
            'release_date',
            'tag',
        ];

        $this->setProperties(
            'video.tv_show',
            'videoTVShowProperties',
            $attributes,
            $validkeys
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addVideo($source = null, $attributes = []): self
    {
        $validKeys = [
            'url',
            'secure_url',
            'type',
            'width',
            'height',
        ];

        $this->videoProperties[] = [
            $source,
            $this->cleanProperties($attributes, $validKeys),
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAudio($source = null, $attributes = []): self
    {
        $validKeys = [
            'url',
            'secure_url',
            'type',
        ];

        $this->audioProperties[] = [
            $source,
            $this->cleanProperties($attributes, $validKeys),
        ];

        return $this;
    }

    /**
     * Set place properties.
     *
     * @param  array  $attributes  opengraph place attributes
     * @return OpenGraphContract
     */
    public function setPlace(array $attributes = []): self
    {
        $validkeys = [
            'location:latitude',
            'location:longitude',
        ];

        $this->setProperties('place', 'placeProperties', $attributes, $validkeys);

        return $this;
    }

    /**
     * Set product properties.
     *
     * @param  array  $attributes  opengraph product attributes
     * @return OpenGraphContract
     */
    public function setProduct(array $attributes = []): self
    {
        $validkeys = [
            'original_price:amount',
            'original_price:currency',
            'pretax_price:amount',
            'pretax_price:currency',
            'price:amount',
            'price:currency',
            'shipping_cost:amount',
            'shipping_cost:currency',
            'weight:value',
            'weight:units',
            'shipping_weight:value',
            'shipping_weight:units',
            'sale_price:amount',
            'sale_price:currency',
            'sale_price_dates:start',
            'sale_price_dates:end',
        ];

        $this->setProperties('product', 'productProperties', $attributes, $validkeys);

        return $this;
    }

    /**
     * Clean invalid properties.
     *
     * @param  array  $attributes  attributes input
     * @param  string[]  $validKeys  keys that are allowed
     */
    protected function cleanProperties(array $attributes = [], array $validKeys = []): array
    {
        $array = [];

        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $validKeys)) {
                $array[$attribute] = $value;
            }
        }

        return $array;
    }

    /**
     * Set properties.
     *
     * @param  string|null  $type  type of og:type
     * @param  string|null  $key  variable key
     * @param  array  $attributes  inputted opengraph attributes
     * @param  string[]  $validKeys  valid opengraph attributes
     * @return void
     */
    protected function setProperties(
        ?string $type = null,
        ?string $key = null,
        array $attributes = [],
        array $validKeys = []
    ) {
        if (isset($this->properties['type']) && $this->properties['type'] == $type) {
            foreach ($attributes as $attribute => $value) {
                if (in_array($attribute, $validKeys)) {
                    $this->{$key}[$attribute] = $value;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeProperty($key): self
    {
        Arr::forget($this->properties, $key);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addImage($source = null, $attributes = []): self
    {
        $validKeys = [
            'url',
            'secure_url',
            'type',
            'width',
            'height',
            'alt',
        ];

        if (is_array($source)) {
            $this->images[] = $this->cleanProperties($source, $validKeys);
        } else {
            $this->images[] = [
                $source,
                $this->cleanProperties($attributes, $validKeys),
            ];
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addImages(array $urls): self
    {
        array_push($this->images, $urls);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type = null): self
    {
        return $this->addProperty('type', $type);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title = null): self
    {
        return $this->addProperty('title', $title);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description = null): self
    {
        $data = htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false);

        return $this->addProperty('description', Str::limit(strip_tags($data), 200), '.');
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSiteName($name): self
    {
        return $this->addProperty('site_name', $name);
    }
}
