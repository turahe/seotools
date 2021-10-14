<?php

namespace Turahe\SEOTools;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Turahe\SEOTools\Contracts\Pwa as PWAContract;

class PWA implements PWAContract
{
    /**
     * @var array
     */
    protected array $config = [];

    public function __construct(array $defaults = [])
    {
        $this->config = $defaults;

    }
    /**
     * @return Collection
     */
    public function manifestJson(): Collection
    {
        $basicManifest = [
            'name' => config('seotools.site_name'),
            'short_name' => config('seotools.site_title'),
            'start_url' => url('/'),
            'display' => config('seotools.display'),
            'theme_color' => config('seotools.theme_color'),
            'background_color' => config('seotools.background_color'),
            'orientation' => config('seotools.orientation'),
            'status_bar' => config('seotools.status_bar'),
            'prefer_related_applications' => true,
        ];

        foreach (config('site.manifest.icons') as $size => $file) {
            $fileInfo = pathinfo($file['path']);
            $basicManifest['icons'][] = [
                'src' => Storage::url($file['path']),
                'type' => 'image/' . $fileInfo['extension'],
                'sizes' => $size,
                'purpose' => $file['purpose'],
            ];
        }

        if (config('site.manifest.shortcuts')) {
            foreach (config('site.manifest.shortcuts') as $shortcut) {
                if (array_key_exists('icons', $shortcut)) {
                    $fileInfo = pathinfo($shortcut['icons']['src']);
                    $icon = [
                        'src' => $shortcut['icons']['src'],
                        'type' => 'image/' . $fileInfo['extension'],
                        'purpose' => $shortcut['icons']['purpose'],
                    ];
                    if (isset($shortcut['icons']['sizes'])) {
                        $icon['sizes'] = $shortcut['icons']['sizes'];
                    }
                } else {
                    $icon = [];
                }

//                $basicManifest['shortcuts'][] = [
//                    'name' => trans($shortcut['name']),
//                    'description' => trans($shortcut['description']),
//                    'url' => $shortcut['url'],
//                    'icons' => [
//                        $icon,
//                    ],
//                ];
            }
        }

//        foreach (config('site.manifest.custom') as $tag => $value) {
//            $basicManifest[$tag] = $value;
//        }

        return new Collection($basicManifest);
    }


    public function generate($minify = false)
    {

        $title = $this->getTitle();


        $html = [];

        $html[] = '<link rel="manifest" href="' . route('manifest') . '"/>';
        $html[] = '<link rel="alternate" type="application/atom+xml" title="Products" href="'. route('feed'). '"/>';


        if (config('seotools.theme_color')) {
            $html[] = '<meta name="theme-color" content=" '. config('seotools.theme_color') . '" />';
            $html[] = '<meta name="apple-mobile-web-app-status-bar-style" content="'. config('seotools.theme_color') . '" />';
            $html[] = '<meta name="msapplication-TileColor" content="'. config('seotools.theme_color') . '" />';
        }

        if ($title) {
            $html[] = "<meta name=\"application-name\" content=\"{$title}\">";
        }

        $html[] = "<meta name=\"mobile-web-app-capable\" content=\"yes\">";
        $html[] = "<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">";
        foreach (config('seotools.manifest.icons') as $index => $icon) {
            $path = Storage::url(config('app.unique_id') . $icon['path']);
            $html[] = '<link rel="icon" sizes="'.$index.'" href="'.$path.'"/>';
        }

        foreach (config('seotools.manifest.icons') as $index => $icon) {
            $path = Storage::url(config('app.unique_id') . $icon['path']);
            $html[] = '<link rel="apple-touch-icon" sizes="'.$index.'" href="'.$path.'"/>';
        }

        foreach (config('seotools.manifest.icons') as $index => $icon) {
            $path = Storage::url(config('app.unique_id') . $icon['path']);
            $html[] = '<link rel="msapplication-TileImage" sizes="'.$index.'" href="'.$path.'"/>';
        }

        foreach (config('seotools.manifest.splash') as $splash) {
            $path = Storage::url(config('app.unique_id') .$splash['path']);
            $html[] = ' <link href="'.$path.'" media="(device-width: '.$splash['width'].'px) and (device-height: '.$splash['height'].'px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" /> ';
        }


        return ($minify) ? implode('', $html) : implode(PHP_EOL, $html);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title ?: $this->getDefaultTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTitle()
    {
        if (empty($this->title_default)) {
            return $this->config->get('defaults.title', null);
        }

        return $this->title_default;
    }

}
