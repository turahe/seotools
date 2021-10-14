<?php
/**
 * @see https://github.com/Turahe/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "My Title", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'My Title - Dashboard'
            'description'  => 'This description for your website', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [],
            'canonical'    => false, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'My title of json ld', // set false to total remove
            'description' => 'This description for your website', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@Turahe',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'My title of json ld', // set false to total remove
            'description' => 'This description for your website', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],

    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            'ldpi_portrait' => [
                'path' => config('app.unique_id') . '/images/splash/splash-640x1136.png',
                'height' => 200,
                'width' => 320
            ],
            'ldpi_landscape' => [
                'path' => config('app.unique_id') . '/images/splash/splash-750x1334.png',
                'height' => 320,
                'width' => 200
            ],
            'mdpi_portrait' => [
                'path' => config('app.unique_id') . '/images/splash/splash-828x1792.png',
                'height' => 320,
                'width' => 480
            ],
            'mdpi_landscape' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1125x2436.png',
                'height' => 480,
                'width' => 320
            ],
            'hdpi_portrait' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1242x2208.png',
                'height' => 480,
                'width' => 720
            ],
            'hdpi_landscape' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1242x2688.png',
                'height' => 720,
                'width' => 480
            ],
            'xhdpi_portrait' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1536x2048.png',
                'height' => 640,
                'width' => 960
            ],
            'xhdpi_landscape' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1668x2224.png',
                'height' => 960,
                'width' => 640
            ],
            'xxhdpi_portrait' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1668x2388.png',
                'height' => 960,
                'width' => 1440
            ],
            'xxhdpi_landscape' => [
                'path' => config('app.unique_id') . '/images/splash/splash-2048x2732.png',
                'height' => 1440,
                'width' => 960
            ],
            'xxxhdpi_portrait' => [
                'path' => config('app.unique_id') . '/images/splash/splash-1668x2388.png',
                'height' => 1280,
                'width' => 1920
            ],
            'xxxhdpi_landscape' => [
                'path' => config('app.unique_id') . '/images/splash/splash-2048x2732.png',
                'height' => 1920,
                'width' => 1280
            ],

        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];
