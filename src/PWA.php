<?php

namespace Turahe\SEOTools;

use Illuminate\Support\Facades\Storage;
use Turahe\SEOTools\Contracts\Pwa as PWAContract;

class PWA implements PWAContract
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults  = [])
    {
        $this->config = $defaults;
    }
    /**
     * @return array
     */
    public function manifestJson(): array
    {
        $basicManifest = [
            'name' => $this->config['site_name'],
            'short_name' => $this->config['site_title'],
            'start_url' => url('/'),
            'display' => $this->config['display'],
            'theme_color' => $this->config['theme_color'],
            'background_color' => $this->config['background_color'],
            'orientation' => $this->config['orientation'],
            'status_bar' => $this->config['status_bar'],
            'prefer_related_applications' => true,
        ];

        foreach ($this->config['icons'] as $size => $file) {
            $fileInfo = pathinfo($file['path']);
            $basicManifest['icons'][] = [
                'src' => Storage::url($file['path']),
                'type' => 'image/' . $fileInfo['extension'],
                'sizes' => $size,
                'purpose' => $file['purpose'],
            ];
        }

        if ($this->config['shortcuts']) {
            foreach ($this->config['shortcuts'] as $shortcut) {
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

//        foreach (config('custom') as $tag => $value) {
//            $basicManifest[$tag] = $value;
//        }

        return $basicManifest;
    }


    /**
     * @param false $minify
     * @return string
     */
    public function generate($minify = false): string
    {
        $html = [];

        if ($this->config['manifest']) {
            $html[] = '<link rel="manifest" href="' . url('manifest.json') . '"/>';
        }

        if ($this->config['theme_color']) {
            $html[] = '<meta name="theme-color" content=" '. $this->config['theme_color'] . '" />';
            $html[] = '<meta name="apple-mobile-web-app-status-bar-style" content="'. $this->config['theme_color'] . '" />';
            $html[] = '<meta name="msapplication-TileColor" content="'. $this->config['theme_color'] . '" />';
        }

        if ($this->config['name']) {
            $html[] = "<meta name=\"application-name\" content=\"{$this->config['name']}\">";
        }

        $html[] = "<meta name=\"mobile-web-app-capable\" content=\"yes\">";
        $html[] = "<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">";
        if ($this->config['icons']) {
            foreach ($this->config['icons'] as $index => $icon) {
                $html[] = "<link rel=\"icon\" sizes=\"{$index}\" href=\"{$icon['path']}\"/>";
            }


            foreach ($this->config['icons'] as $index => $icon) {
                $html[] = "<link rel=\"apple-touch-icon\" sizes=\"{$index}\" href=\"{$icon['path']}\"/>";
            }

            foreach ($this->config['icons'] as $index => $icon) {
                $html[] = "<link rel=\"msapplication-TileImage\" sizes=\"{$index}\" href=\"{$icon['path']}\"/>";
            }
        }

        if ($this->config['splash']) {
            foreach ($this->config['splash'] as $splash) {
                $html[] = "<link href=\"{$splash['path']}\" media=\"(device-width: {$splash['width']}px) and (device-height: {$splash['height']}px) and (-webkit-device-pixel-ratio: 2)\" rel=\"apple-touch-startup-image\" />";
            }
        }


        return ($minify) ? implode('', $html) : implode(PHP_EOL, $html);
    }
}
