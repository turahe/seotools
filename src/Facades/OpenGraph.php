<?php

namespace Turahe\SEOTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * OpenGraph is a facade for the `OpenGraph` implementation access.
 *
 * @see \Turahe\SEOTools\Contracts\OpenGraph
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph addProperty(string $key, array|string $value)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph removeProperty(string $key)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph addImage(string $url, array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph addImages(array $urls)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setTitle(string $title)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setDescription(string $description)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setUrl(string $url)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setSiteName(string $name)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setType(string|null $type = null)
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setArticle(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setProfile(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setMusicSong(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setMusicAlbum(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setMusicPlaylist(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setMusicRadioStation(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setVideoMovie(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setVideoEpisode(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setVideoOther(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setVideoTVShow(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph setBook(array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph addVideo(string|null $source = null, array $attributes = [])
 * @method static \Turahe\SEOTools\Contracts\OpenGraph addAudio(string|null $source = null, array $attributes = [])
 */
class OpenGraph extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'seotools.opengraph';
    }
}
