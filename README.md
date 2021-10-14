
For license information check the [LICENSE](LICENSE.md)-file.

Features
--------

- Friendly simple interface
- Easy of set titles and meta tags
- Easy of set metas for [Twitter Cards](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/abouts-cards) and [Open Graph](https://ogp.me/)
- Easy of set for [JSON Linked Data](https://json-ld.org/)
- Easy of set for PWA (Progressive web application)

Installation
------------

### 1 - Dependency

The first step is using composer to install the package and automatically update your `composer.json` file, you can do this by running:

```shell
composer require turahe/seotools
```

> **Note**: If you are using Laravel 5.5, the steps 2 and 3, for providers and aliases, are unnecessaries. SEOTools supports Laravel new [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

### 2 - Provider

You need to update your application configuration in order to register the package so it can be loaded by Laravel, just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

> `config/app.php`

```php
<?php

return [
    // ...
    'providers' => [
        Turahe\Metatags\Providers\MetaTagsServiceProvider::class,
        // ...
    ],
    // ...
];
```

#### Lumen

Go to `/bootstrap/app.php` file and add this line:

```php
<?php
// ...

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

// ...

$app->register(Turahe\Metatags\Providers\MetaTagsServiceProvider::class);

// ...

return $app;
```

### 3 - Facades

> Note: facades are not supported in Lumen.

You may get access to the SEO tool services using following facades:

 - `Turahe\Metatags\Facades\SEOMeta`
 - `Turahe\Metatags\Facades\OpenGraph`
 - `Turahe\Metatags\Facades\TwitterCard`
 - `Turahe\Metatags\Facades\JsonLd`
 - `Turahe\Metatags\Facades\JsonLdMulti`
 - `Turahe\Metatags\Facades\SEOTools`
 - `Turahe\Metatags\Facades\Manifest`

You can setup a short-version aliases for these facades in your `config/app.php` file. For example:

```php
<?php

return [
    // ...
    'aliases' => [
        'Meta'       => Turahe\Metatags\Facades\SEOMeta::class,
        'OpenGraph'     => Turahe\Metatags\Facades\OpenGraph::class,
        'Twitter'       => Turahe\Metatags\Facades\TwitterCard::class,
        'JsonLd'        => Turahe\Metatags\Facades\JsonLd::class,
        'JsonLdMulti'   => Turahe\Metatags\Facades\JsonLdMulti::class,
        'Manifest'   => Turahe\Metatags\Facades\Manifest::class,
        // or
        'SEO' => Turahe\Metatags\Facades\SEOTools::class,
        // ...
    ],
    // ...
];
```

### 4 Configuration

#### Publish config

In your terminal type

```shell
php artisan vendor:publish
```

or

```shell
php artisan vendor:publish --provider="Turahe\Metatags\Providers\MetaTagsServiceProvider"
```

> Lumen does not support this command, for it you should copy the file `config/seotools.php` to `config/seotools.php` of your project

In `seotools.php` configuration file you can determine the properties of the default values and some behaviors.

#### seotools.php

- **meta**
   - `defaults` - What values are displayed if not specified any value for the page display. If the value is `false`, nothing is displayed.
   - `webmaster` - Are the settings of tags values for major webmaster tools. If you are `null` nothing is displayed.
- **opengraph**
   - `defaults` - Are the properties that will always be displayed and when no other value is set instead. **You can add additional tags** that are not included in the original configuration file.
- **twitter**
   - `defaults` - Are the properties that will always be displayed and when no other value is set instead. **You can add additional tags** that are not included in the original configuration file.
- **json-ld**
   - `defaults` - Are the properties that will always be displayed and when no other value is set instead. **You can add additional tags** that are not included in the original configuration file.
- **manifest**
  - `defaults` - Are the properties that will always be displayed and when no other value is set instead. **You can add additional tags** that are not included in the original configuration file.

Usage
-----

### Lumen Usage

> Note: facades are not supported in Lumen.

```php
<?php

$seotools = app('seotools');
$seotools = app('seotools.meta');
$twitter = app('seotools.twitter');
$opengraph = app('seotools.opengraph');
$jsonld = app('seotools.json-ld');
$jsonldMulti = app('seotools.json-ld-multi');
$jsonldMulti = app('seotools.manifest');
// The behavior is the same as the facade

echo app('seotools')->generate();
```

### Meta tags Generator

With **SEOMeta** you can create meta tags to the `head`

### Opengraph tags Generator

With **OpenGraph** you can create OpenGraph tags to the `head`

### Twitter for Twitter Cards tags Generator

With **Twitter** you can create OpenGraph tags to the `head`

#### In your controller

```php
<?php

namespace App\Http\Controllers;

use Turahe\Metatags\Facades\SEOMeta;
use Turahe\Metatags\Facades\OpenGraph;
use Turahe\Metatags\Facades\TwitterCard;
use Turahe\Metatags\Facades\JsonLd;
// OR with multi
use Turahe\Metatags\Facades\JsonLdMulti;

// OR
use Turahe\Metatags\Facades\SEOTools;

class CommomController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Home');
        SEOMeta::setDescription('This is my page description');
        SEOMeta::setCanonical('https://codecasts.com.br/lesson');

        OpenGraph::setDescription('This is my page description');
        OpenGraph::setTitle('Home');
        OpenGraph::setUrl('http://current.url.com');
        OpenGraph::addProperty('type', 'articles');

        TwitterCard::setTitle('Homepage');
        TwitterCard::setSite('@turahe');

        JsonLd::setTitle('Homepage');
        JsonLd::setDescription('This is my page description');
        JsonLd::addImage('https://codecasts.com.br/img/logo.jpg');

        // OR

        SEOTools::setTitle('Home');
        SEOTools::setDescription('This is my page description');
        SEOTools::opengraph()->setUrl('http://current.url.com');
        SEOTools::setCanonical('https://codecasts.com.br/lesson');
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@turahe');
        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');

        $posts = Post::all();

        return view('myindex', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::find($id);

        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->resume);
        SEOMeta::addMeta('article:published_time', $post->published_date->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $post->category, 'property');
        SEOMeta::addKeyword(['key1', 'key2', 'key3']);

        OpenGraph::setDescription($post->resume);
        OpenGraph::setTitle($post->title);
        OpenGraph::setUrl('http://current.url.com');
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['id-id', 'en-us']);

        OpenGraph::addImage($post->cover->url);
        OpenGraph::addImage($post->images->list('url'));
        OpenGraph::addImage(['url' => 'http://image.url.com/cover.jpg', 'size' => 300]);
        OpenGraph::addImage('http://image.url.com/cover.jpg', ['height' => 300, 'width' => 300]);

        JsonLd::setTitle($post->title);
        JsonLd::setDescription($post->resume);
        JsonLd::setType('Article');
        JsonLd::addImage($post->images->list('url'));

        // OR with multi

        JsonLdMulti::setTitle($post->title);
        JsonLdMulti::setDescription($post->resume);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($post->images->list('url'));
        if(! JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - '.$post->title);
        }

        // Namespace URI: http://ogp.me/ns/article#
        // article
        OpenGraph::setTitle('Article')
            ->setDescription('Some Article')
            ->setType('article')
            ->setArticle([
                'published_time' => 'datetime',
                'modified_time' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => 'profile / array',
                'section' => 'string',
                'tag' => 'string / array'
            ]);

        // Namespace URI: http://ogp.me/ns/book#
        // book
        OpenGraph::setTitle('Book')
            ->setDescription('Some Book')
            ->setType('book')
            ->setBook([
                'author' => 'profile / array',
                'isbn' => 'string',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // Namespace URI: http://ogp.me/ns/profile#
        // profile
        OpenGraph::setTitle('Profile')
             ->setDescription('Some Person')
            ->setType('profile')
            ->setProfile([
                'first_name' => 'string',
                'last_name' => 'string',
                'username' => 'string',
                'gender' => 'enum(male, female)'
            ]);

        // Namespace URI: http://ogp.me/ns/music#
        // music.song
        OpenGraph::setType('music.song')
            ->setMusicSong([
                'duration' => 'integer',
                'album' => 'array',
                'album:disc' => 'integer',
                'album:track' => 'integer',
                'musician' => 'array'
            ]);

        // music.album
        OpenGraph::setType('music.album')
            ->setMusicAlbum([
                'song' => 'music.song',
                'song:disc' => 'integer',
                'song:track' => 'integer',
                'musician' => 'profile',
                'release_date' => 'datetime'
            ]);

         //music.playlist
        OpenGraph::setType('music.playlist')
            ->setMusicPlaylist([
                'song' => 'music.song',
                'song:disc' => 'integer',
                'song:track' => 'integer',
                'creator' => 'profile'
            ]);

        // music.radio_station
        OpenGraph::setType('music.radio_station')
            ->setMusicRadioStation([
                'creator' => 'profile'
            ]);

        // Namespace URI: http://ogp.me/ns/video#
        // video.movie
        OpenGraph::setType('video.movie')
            ->setVideoMovie([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // video.episode
        OpenGraph::setType('video.episode')
            ->setVideoEpisode([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array',
                'series' => 'video.tv_show'
            ]);

        // video.tv_show
        OpenGraph::setType('video.tv_show')
            ->setVideoTVShow([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // video.other
        OpenGraph::setType('video.other')
            ->setVideoOther([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // og:video
        OpenGraph::addVideo('http://example.com/movie.swf', [
                'secure_url' => 'https://example.com/movie.swf',
                'type' => 'application/x-shockwave-flash',
                'width' => 400,
                'height' => 300
            ]);

        // og:audio
        OpenGraph::addAudio('http://example.com/sound.mp3', [
                'secure_url' => 'https://secure.example.com/sound.mp3',
                'type' => 'audio/mpeg'
            ]);

        // og:place
        OpenGraph::setTitle('Place')
             ->setDescription('Some Place')
            ->setType('place')
            ->setPlace([
                'location:latitude' => 'float',
                'location:longitude' => 'float',
            ]);

        return view('myshow', compact('post'));
    }
}
```

#### SEOTrait

```php
<?php

namespace App\Http\Controllers;

use Turahe\Metatags\Traits\SEOTools as SEOToolsTrait;

class CommomController extends Controller
{
    use SEOToolsTrait;

    public function index()
    {
        $this->seo()->setTitle('Home');
        $this->seo()->setDescription('This is my page description');
        $this->seo()->opengraph()->setUrl('http://current.url.com');
        $this->seo()->opengraph()->addProperty('type', 'articles');
        $this->seo()->twitter()->setSite('@turahe');
        $this->seo()->jsonLd()->setType('Article');

        $posts = Post::all();

        return view('myindex', compact('posts'));
    }
}
```

### In Your View

> **Pro Tip**: Pass the parameter `true` to get minified code and reduce filesize.

```html
<html>
<head>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    // OR with multi
    {!! JsonLdMulti::generate() !!}

    <!-- OR -->
    {!! SEO::generate() !!}

    <!-- MINIFIED -->
    {!! SEO::generate(true) !!}

    <!-- LUMEN -->
    {!! app('seotools')->generate() !!}
</head>
<body>

</body>
</html>
```

```html
<html>
<head>
    <title>Title - My Title Website</title>
    <meta name='description' itemprop='description' content='description...' />
    <meta name='keywords' content='key1, key2, key3' />
    <meta property='article:published_time' content='2015-01-31T20:30:11-02:00' />
    <meta property='article:section' content='news' />

    <meta property="og:description"content="description..." />
    <meta property="og:title"content="Title" />
    <meta property="og:url"content="http://current.url.com" />
    <meta property="og:type"content="article" />
    <meta property="og:locale"content="pt-br" />
    <meta property="og:locale:alternate"content="id-id" />
    <meta property="og:locale:alternate"content="en-us" />
    <meta property="og:site_name"content="name" />
    <meta property="og:image"content="http://image.url.com/cover.jpg" />
    <meta property="og:image"content="http://image.url.com/img1.jpg" />
    <meta property="og:image"content="http://image.url.com/img2.jpg" />
    <meta property="og:image"content="http://image.url.com/img3.jpg" />
    <meta property="og:image:url"content="http://image.url.com/cover.jpg" />
    <meta property="og:image:size"content="300" />

    <meta name="twitter:card"content="summary" />
    <meta name="twitter:title"content="Title" />
    <meta name="twitter:site"content="@turahe" />

    <script type="application/ld+json">{"@context":"https://schema.org","@type":"Article","name":"Title - My Title Website"}</script>
    <!-- OR with multi -->
    <script type="application/ld+json">{"@context":"https://schema.org","@type":"Article","name":"Title - My Title Website"}</script>
    <script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Title - My Title Website"}</script>
</head>
<body>

</body>
</html>
```

#### API (SEOMeta)

```php
<?php

use Turahe\Metatags\Facades\SEOMeta;

SEOMeta::addKeyword($keyword);
SEOMeta::addMeta($meta, $value = null, $name = 'name');
SEOMeta::addAlternateLanguage($lang, $url);
SEOMeta::addAlternateLanguages(array $languages);
SEOMeta::setTitleSeparator($separator);
SEOMeta::setTitle($title);
SEOMeta::setTitleDefault($default);
SEOMeta::setDescription($description);
SEOMeta::setKeywords($keywords);
SEOMeta::setRobots($robots);
SEOMeta::setCanonical($url);
SEOMeta::setPrev($url);
SEOMeta::setNext($url);
SEOMeta::removeMeta($key);

// You can chain methods
SEOMeta::setTitle($title)
            ->setDescription($description)
            ->setKeywords($keywords)
            ->addKeyword($keyword)
            ->addMeta($meta, $value);

// Retrieving data
SEOMeta::getTitle();
SEOMeta::getTitleSession();
SEOMeta::getTitleSeparator();
SEOMeta::getKeywords();
SEOMeta::getDescription();
SEOMeta::getCanonical($url);
SEOMeta::getPrev($url);
SEOMeta::getNext($url);
SEOMeta::getRobots();
SEOMeta::reset();

SEOMeta::generate();
```

#### API (OpenGraph)

```php
<?php

use Turahe\Metatags\Facades\OpenGraph;

OpenGraph::addProperty($key, $value); // value can be string or array
OpenGraph::addImage($url); // add image url
OpenGraph::addImages($url); // add an array of url images
OpenGraph::setTitle($title); // define title
OpenGraph::setDescription($description);  // define description
OpenGraph::setUrl($url); // define url
OpenGraph::setSiteName($name); //define site_name

// You can chain methods
OpenGraph::addProperty($key, $value)
            ->addImage($url)
            ->addImages($url)
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl($url)
            ->setSiteName($name);

// Generate html tags
OpenGraph::generate();
```

### API (TwitterCard)

```php
<?php

use Turahe\Metatags\Facades\TwitterCard;

TwitterCard::addValue($key, $value); // value can be string or array
TwitterCard::setType($type); // type of twitter card tag
TwitterCard::setTitle($type); // title of twitter card tag
TwitterCard::setSite($type); // site of twitter card tag
TwitterCard::setDescription($type); // description of twitter card tag
TwitterCard::setUrl($type); // url of twitter card tag
TwitterCard::setImage($url); // add image url

// You can chain methods
TwitterCard::addValue($key, $value)
            ->setType($type)
            ->setImage($url)
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl($url)
            ->setSite($name);

// Generate html tags
TwitterCard::generate();
```

### API (JsonLd)

```php
<?php

use Turahe\Metatags\Facades\JsonLd;

JsonLd::addValue($key, $value); // value can be string or array
JsonLd::setType($type); // type of twitter card tag
JsonLd::setTitle($type); // title of twitter card tag
JsonLd::setSite($type); // site of twitter card tag
JsonLd::setDescription($type); // description of twitter card tag
JsonLd::setUrl($type); // url of twitter card tag
JsonLd::setImage($url); // add image url

// You can chain methods
JsonLd::addValue($key, $value)
    ->setType($type)
    ->setImage($url)
    ->setTitle($title)
    ->setDescription($description)
    ->setUrl($url)
    ->setSite($name);

// Generate html tags
JsonLd::generate();
```

### API (JsonLdMulti)

```php
<?php

use Turahe\Metatags\Facades\JsonLdMulti;

JsonLdMulti::newJsonLd(); // create a new JsonLd group
JsonLdMulti::isEmpty(); // check if the current JsonLd group is empty
JsonLdMulti::select($index); // choose the JsonLd group that will be edited by the methods below
JsonLdMulti::addValue($key, $value); // value can be string or array
JsonLdMulti::setType($type); // type of twitter card tag
JsonLdMulti::setTitle($type); // title of twitter card tag
JsonLdMulti::setSite($type); // site of twitter card tag
JsonLdMulti::setDescription($type); // description of twitter card tag
JsonLdMulti::setUrl($type); // url of twitter card tag
JsonLdMulti::setImage($url); // add image url

// You can chain methods
JsonLdMulti::addValue($key, $value)
    ->setType($type)
    ->setImage($url)
    ->setTitle($title)
    ->setDescription($description)
    ->setUrl($url)
    ->setSite($name);
// You can add an other group
if(! JsonLdMulti::isEmpty()) {
    JsonLdMulti::newJsonLd()
        ->setType($type)
        ->setImage($url)
        ->setTitle($title)
        ->setDescription($description)
        ->setUrl($url)
        ->setSite($name);
}
// Generate html tags
JsonLdMulti::generate();
// You will have retrieve <script content="application/ld+json"/>
```

#### API (SEO)

> Facilitates access to all the SEO Providers

```php
<?php

use Turahe\Metatags\Facades\SEOTools;

SEOTools::seotools();
SEOTools::twitter();
SEOTools::opengraph();
SEOTools::jsonLd();
SEOTools::manifest();

SEOTools::setTitle($title);
SEOTools::getTitle($session = false);
SEOTools::setDescription($description);
SEOTools::setCanonical($url);
SEOTools::addImages($urls);
```

Troubleshooting
-----------------

While running the Laravel test server:

1. Verify that `/manifest.json` is being served
2. Verify that `/serviceworker.js` is being served
3. Use the Application tab in the Chrome Developer Tools to verify the progressive web app is configured correctly.
4. Use the "Add to homescreen" link on the Application Tab to verify you can add the app successfully.

The Service Worker
-----------------
By default, the service worker implemented by this app is:

```javascript
var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/css/app.css',
    '/js/app.js',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
    '/images/icons/splash-640x1136.png',
    '/images/icons/splash-750x1334.png',
    '/images/icons/splash-1242x2208.png',
    '/images/icons/splash-1125x2436.png',
    '/images/icons/splash-828x1792.png',
    '/images/icons/splash-1242x2688.png',
    '/images/icons/splash-1536x2048.png',
    '/images/icons/splash-1668x2224.png',
    '/images/icons/splash-1668x2388.png',
    '/images/icons/splash-2048x2732.png'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});

```
To customize service worker functionality, update the `public/serviceworker.js`.

The offline view
------------------
By default, the offline view is implemented in resources/views/vendor/seotools/offline.blade.php
```html
@extends('layouts.app')

@section('content')

    <h1>You are currently not connected to any networks.</h1>

@endsection

```
