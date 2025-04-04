<?php

namespace Turahe\SEOTools\Providers;

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
class SEOToolsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $configFile = __DIR__.'/../../config/seotools.php';

        if ($this->isLumen()) {
            $this->app->configure('seotools');
        } else {
            $this->publishes([
                $configFile => config_path('seotools.php'),
            ]);
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

        $this->app->singleton('seotools', function () {
            return new \Turahe\SEOTools\Tools;
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
        return ! $this->isLaravel();
    }
}
