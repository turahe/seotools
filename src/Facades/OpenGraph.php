<?php

namespace Turahe\Metatags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * OpenGraph is a facade for the `OpenGraph` implementation access.
 *
 * @see \Turahe\Metatags\Contracts\OpenGraph
 *
 * @method static string generate(bool $minify = false)
 * @method static \Turahe\Metatags\Contracts\OpenGraph addProperty(string $key, array|string $value)
 * @method static \Turahe\Metatags\Contracts\OpenGraph removeProperty(string $key)
 * @method static \Turahe\Metatags\Contracts\OpenGraph addImage(string $url, array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph addImages(array $urls)
 * @method static \Turahe\Metatags\Contracts\OpenGraph setTitle(string $title)
 * @method static \Turahe\Metatags\Contracts\OpenGraph setDescription(string $description)
 * @method static \Turahe\Metatags\Contracts\OpenGraph setUrl(string $url)
 * @method static \Turahe\Metatags\Contracts\OpenGraph setSiteName(string $name)
 * @method static \Turahe\Metatags\Contracts\OpenGraph setType(string|null $type = null)
 * @method static \Turahe\Metatags\Contracts\OpenGraph setArticle(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setProfile(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setMusicSong(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setMusicAlbum(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setMusicPlaylist(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setMusicRadioStation(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setVideoMovie(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setVideoEpisode(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setVideoOther(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setVideoTVShow(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph setBook(array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph addVideo(string|null $source = null, array $attributes = [])
 * @method static \Turahe\Metatags\Contracts\OpenGraph addAudio(string|null $source = null, array $attributes = [])
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
