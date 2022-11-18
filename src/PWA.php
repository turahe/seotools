<?php
namespace Turahe\SEOTools;

use Illuminate\Config\Repository;
use Turahe\SEOTools\Contracts\Pwa as PWAContract;

class PWA implements PWAContract
{
    /**
     * The image icons.
     *
     * @var array
     */
    protected $icons;

    /**
     * The image splash.
     *
     * @var array
     */
    protected $splash;

    /**
     * The icons shortcut.
     *
     * @var array
     */
    protected $shortcut;
    /**
     * @var array
     */
    protected $config;

    public function __construct(array $defaults = [])
    {
        $this->config = new Repository($defaults);
    }
    /**
     * @return array
     */
    public function manifestJson(): array
    {
        $basicManifest = [
            'name'                        => $this->config->get('site_name'),
            'short_name'                  => $this->config->get('site_title'),
            'start_url'                   => url('/'),
            'display'                     => $this->config->get('display'),
            'theme_color'                 => $this->config->get('theme_color'),
            'background_color'            => $this->config->get('background_color'),
            'orientation'                 => $this->config->get('orientation'),
            'status_bar'                  => $this->config->get('status_bar'),
            'prefer_related_applications' => true,
        ];

        foreach ($this->config['icons'] as $size => $file) {
            $fileInfo = pathinfo($file['path']);
            $basicManifest['icons'][] = [
                'src'     => asset($file['path']),
                'type'    => 'image/' . $fileInfo['extension'],
                'sizes'   => $size,
                'purpose' => $file['purpose'],
            ];
        }

        if ($this->config->get('shortcuts')) {
            foreach ($this->config->get('shortcuts') as $shortcut) {
                if (array_key_exists('icons', $shortcut)) {
                    $fileInfo = pathinfo($shortcut['icons']['src']);
                    $icon = [
                        'src'     => $shortcut['icons']['src'],
                        'type'    => 'image/' . $fileInfo['extension'],
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

    public function generate($minify = false): string
    {
        $icons = $this->getIcons();
        $splash = $this->getSplash();
        $shortcut = $this->getShortcut();

        $html = [];

        if ($this->config) {
            $html[] = '<link rel="manifest" href="' . url($this->config->get('manifest_url', 'manifest.json')) . '"/>';
        }

        if ($this->config->get('theme_color', false)) {
            $html[] = '<meta name="theme-color" content=" '. $this->config->get('theme_color', 'ffffff') . '" />';
            $html[] = '<meta name="apple-mobile-web-app-status-bar-style" content="'. $this->config->get('theme_color', 'ffffff') . '" />';
            $html[] = '<meta name="msapplication-TileColor" content="'. $this->config->get('theme_color', 'ffffff') . '" />';
        }

        if ($this->config->get('name', false)) {
            $html[] = "<meta name=\"application-name\" content=\"{$this->config->get('name', 'Turahe')}\">";
        }

        $html[] = '<meta name="mobile-web-app-capable" content="yes">';
        $html[] = '<meta name="apple-mobile-web-app-capable" content="yes">';

        if ($icons) {
            foreach ($icons as $index => $icon) {
                $path = asset($icon['path']);
                $html[] = "<link rel=\"icon\" sizes=\"{$index}\" href=\"{$path}\"/>";
            }

            foreach ($icons as $index => $icon) {
                $path = asset($icon['path']);
                $html[] = "<link rel=\"apple-touch-icon\" sizes=\"{$index}\" href=\"{$path}\"/>";
            }

            foreach ($icons as $index => $icon) {
                $path = asset($icon['path']);
                $html[] = "<link rel=\"msapplication-TileImage\" sizes=\"{$index}\" href=\"{$path}\"/>";
            }
        }

        if ($splash) {
            foreach ($splash as $image) {
                $path = url($image['path']);
                $html[] = "<link href=\"{$path}\" media=\"(device-width: {$image['width']}px) and (device-height: {$image['height']}px) and (-webkit-device-pixel-ratio: 2)\" rel=\"apple-touch-startup-image\" />";
            }
        }

        return ($minify) ? implode('', $html) : implode(PHP_EOL, $html);
    }

    /**
     * {@inheritdoc}
     */
    public function getIcons()
    {
        return $this->icons ?: $this->getDefaultIcons();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultIcons()
    {
        if (empty($this->icons_default)) {
            return $this->config->get('icons', null);
        }

        return $this->icons_default;
    }

    /**
     * {@inheritdoc}
     */
    public function getSplash()
    {
        return $this->splash ?: $this->getDefaultSplash();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSplash()
    {
        if (empty($this->splash_default)) {
            return $this->config->get('splash', null);
        }

        return $this->splash_default;
    }

    /**
     * {@inheritdoc}
     */
    public function getShortcut()
    {
        return $this->shortcut ?: $this->getDefaultShortcut();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultShortcut()
    {
        if (empty($this->shortcut_default)) {
            return $this->config->get('shortcut', null);
        }

        return $this->shortcut_default;
    }
}
