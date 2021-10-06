<?php

namespace Turahe\Metatags\Providers;

use Turahe\Metatags\Contracts;
use Turahe\Metatags\JsonLd;
use Turahe\Metatags\JsonLdMulti;
use Turahe\Metatags\OpenGraph;
use Turahe\Metatags\SEOMeta;
use Turahe\Metatags\SEOTools;
use Turahe\Metatags\TwitterCards;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * MetaTagsServiceProvider bootstraps SEO tools services to the application.
 * This service provider will be automatically discovered by Laravel after this package installed.
 * For Lumen it should be registered manually at 'bootstrap/app.php'. For example:
 * ```php
 * <?php
 * // ...
 * $app = new Laravel\Lumen\Application(
 *     dirname(__DIR__)
 * );
 * // ...
 * $app->register(Turahe\Metatags\Providers\MetaTagsServiceProvider::class);
 * // ...
 * return $app;
 * ```
 *
 * @see \Turahe\Metatags\Contracts\SEOTools
 * @see \Turahe\Metatags\Contracts\MetaTags
 * @see \Turahe\Metatags\Contracts\OpenGraph
 * @see \Turahe\Metatags\Contracts\TwitterCards
 * @see \Turahe\Metatags\Contracts\JsonLd
 * @see \Turahe\Metatags\Contracts\JsonLdMulti
 */
class MetaTagsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $configFile = __DIR__ . './../../config/metatags.php';

        if ($this->isLumen()) {
            $this->app->configure('metatags');
        } else {
            $this->publishes([
                $configFile => config_path('metatags.php'),
            ]);
        }

        if (config('metatags.manifest.enabled')) {
            $this->registerRoutes();
        }

        $this->mergeConfigFrom($configFile, 'metatags');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('metatags.meta', function ($app) {
            return new SEOMeta($app['config']->get('metatags.meta', []));
        });

        $this->app->singleton('metatags.opengraph', function ($app) {
            return new OpenGraph($app['config']->get('metatags.opengraph', []));
        });

        $this->app->singleton('metatags.twitter', function ($app) {
            return new TwitterCards($app['config']->get('metatags.twitter.defaults', []));
        });

        $this->app->singleton('metatags.json-ld', function ($app) {
            return new JsonLd($app['config']->get('metatags.json-ld.defaults', []));
        });

        $this->app->singleton('metatags.json-ld-multi', function ($app) {
            return new JsonLdMulti($app['config']->get('metatags.json-ld.defaults', []));
        });

        $this->app->singleton('metatags', function () {
            return new SEOTools();
        });

        $this->app->bind(Contracts\MetaTags::class, 'metatags.meta');
        $this->app->bind(Contracts\OpenGraph::class, 'metatags.opengraph');
        $this->app->bind(Contracts\TwitterCards::class, 'metatags.twitter');
        $this->app->bind(Contracts\JsonLd::class, 'metatags.json-ld');
        $this->app->bind(Contracts\JsonLdMulti::class, 'metatags.json-ld-multi');
        $this->app->bind(Contracts\SEOTools::class, 'metatags');
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            Contracts\SEOTools::class,
            Contracts\MetaTags::class,
            Contracts\TwitterCards::class,
            Contracts\OpenGraph::class,
            Contracts\JsonLd::class,
            Contracts\JsonLdMulti::class,
            'metatags',
            'metatags.meta',
            'metatags.opengraph',
            'metatags.twitter',
            'metatags.json-ld',
            'metatags.json-ld-multi',
        ];
    }

    /**
     * Register new routes to projects.
     */
    protected function registerRoutes()
    {
        $router = $this->app['router'];
        require __DIR__.'/../routes/web.php';
    }

    /**
     * Check if Laravel.
     *
     * @return bool
     */
    protected function isLaravel()
    {
        return app() instanceof \Illuminate\Foundation\Application;
    }

    /**
     * Check if Is Laravel or Lumen.
     *
     * @return bool
     */
    protected function isLumen()
    {
        return !$this->isLaravel();
    }
}
