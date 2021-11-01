<?php

namespace Turahe\SEOTools\Providers;

use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * SEOToolsServiceProvider bootstraps SEO tools services to the application.
 * This service provider will be automatically discovered by Laravel after this package installed.
 * For Lumen it should be registered manually at 'bootstrap/app.php'. For example:
 * ```php
 * <?php
 * // ...
 * $app = new Laravel\Lumen\Application(
 *     dirname(__DIR__)
 * );
 * // ...
 * $app->register(Turahe\Tools\Providers\SEOToolsServiceProvider::class);
 * // ...
 * return $app;
 * ```
 *
 * @see \Turahe\SEOTools\Contracts\Tools
 * @see \Turahe\SEOTools\Contracts\Meta
 * @see \Turahe\SEOTools\Contracts\OpenGraph
 * @see \Turahe\SEOTools\Contracts\TwitterCards
 * @see \Turahe\SEOTools\Contracts\JsonLd
 * @see \Turahe\SEOTools\Contracts\JsonLdMulti
 */
class SEOToolsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $configFile = __DIR__ . '/../../config/seotools.php';

        if ($this->isLumen()) {
            $this->app->configure('seotools');
        } else {
            $this->publishes([
                $configFile => config_path('seotools.php'),
            ]);
        }

        $this->registerViews();
        $this->registerIcons();
        $this->registerRoutes();

        if (config('seotools.manifest.enabled')) {
            $this->registerRoutes();
        }

        $this->mergeConfigFrom($configFile, 'seotools');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('seotools.metatags', function ($app) {
            return new \Turahe\SEOTools\Meta($app['config']->get('seotools.meta', []));
        });

        $this->app->singleton('seotools.opengraph', function ($app) {
            return new \Turahe\SEOTools\OpenGraph($app['config']->get('seotools.opengraph', []));
        });

        $this->app->singleton('seotools.twitter', function ($app) {
            return new \Turahe\SEOTools\TwitterCards($app['config']->get('seotools.twitter.defaults', []));
        });

        $this->app->singleton('seotools.json-ld', function ($app) {
            return new \Turahe\SEOTools\JsonLd($app['config']->get('seotools.json-ld.defaults', []));
        });

        $this->app->singleton('seotools.json-ld-multi', function ($app) {
            return new \Turahe\SEOTools\JsonLdMulti($app['config']->get('seotools.json-ld.defaults', []));
        });

        $this->app->singleton('seotools.pwa', function ($app) {
            return new \Turahe\SEOTools\PWA($app['config']->get('seotools.pwa', []));
        });

        $this->app->singleton('seotools', function () {
            return new \Turahe\SEOTools\Tools();
        });

        $this->app->bind(\Turahe\SEOTools\Contracts\Meta::class, 'seotools.metatags');
        $this->app->bind(\Turahe\SEOTools\Contracts\OpenGraph::class, 'seotools.opengraph');
        $this->app->bind(\Turahe\SEOTools\Contracts\TwitterCards::class, 'seotools.twitter');
        $this->app->bind(\Turahe\SEOTools\Contracts\JsonLd::class, 'seotools.json-ld');
        $this->app->bind(\Turahe\SEOTools\Contracts\JsonLdMulti::class, 'seotools.json-ld-multi');
        $this->app->bind(\Turahe\SEOTools\Contracts\Tools::class, 'seotools');
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            \Turahe\SEOTools\Contracts\Tools::class,
            \Turahe\SEOTools\Contracts\Meta::class,
            \Turahe\SEOTools\Contracts\TwitterCards::class,
            \Turahe\SEOTools\Contracts\OpenGraph::class,
            \Turahe\SEOTools\Contracts\JsonLd::class,
            \Turahe\SEOTools\Contracts\JsonLdMulti::class,
            'seotools',
            'seotools.metatags',
            'seotools.opengraph',
            'seotools.twitter',
            'seotools.json-ld',
            'seotools.json-ld-multi',
        ];
    }

    /**
     * Register new routers to projects.
     */
    protected function registerRoutes()
    {
        $router = $this->app['router'];
        require __DIR__.'./../../routers/web.php';
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
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/vendor/seo');

        $sourcePath = __DIR__ . '/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/vendor/seo';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'seo');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerIcons()
    {
        $iconsPath = public_path('images/icons');

        $sourcePath = __DIR__.'/resources/assets/images/icons';

        $this->publishes([
            $sourcePath => $iconsPath
        ], 'icons');
    }

    /**
     * Register serviceworker.js.
     *
     * @return void
     */
    protected function registerServiceworker()
    {
        $publicPath = public_path();

        $sourcePath = __DIR__.'./resources/assets/js';

        $this->publishes([
            $sourcePath => $publicPath
        ], 'serviceworker');
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
