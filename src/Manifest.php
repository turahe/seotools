<?php

namespace Turahe\Metatags;

class Manifest
{
    public function generate()
    {
        $basicManifest =  [
            'name' => config('metatags.manifest.name'),
            'short_name' => config('metatags.manifest.short_name'),
            'start_url' => asset(config('metatags.manifest.start_url')),
            'display' => config('metatags.manifest.display'),
            'theme_color' => config('metatags.manifest.theme_color'),
            'background_color' => config('metatags.manifest.background_color'),
            'orientation' =>  config('metatags.manifest.orientation'),
            'status_bar' =>  config('metatags.manifest.status_bar'),
            'splash' =>  config('metatags.manifest.splash')
        ];

        foreach (config('metatags.manifest.icons') as $size => $file) {
            $fileInfo = pathinfo($file['path']);
            $basicManifest['icons'][] = [
                'src' => $file['path'],
                'type' => 'image/' . $fileInfo['extension'],
                'sizes' => (isset($file['sizes']))?$file['sizes']:$size,
                'purpose' => $file['purpose']
            ];
        }

        if (config('metatags.manifest.shortcuts')) {
            foreach (config('metatags.manifest.shortcuts') as $shortcut) {

                if (array_key_exists("icons", $shortcut)) {
                    $fileInfo = pathinfo($shortcut['icons']['src']);
                    $icon = [
                        'src' => $shortcut['icons']['src'],
                        'type' => 'image/' . $fileInfo['extension'],
                        'purpose' => $shortcut['icons']['purpose']
                    ];
                    if(isset($shortcut['icons']['sizes'])) {
                        $icon["sizes"] = $shortcut['icons']['sizes'];
                    }
                } else {
                    $icon = [];
                }

                $basicManifest['shortcuts'][] = [
                    'name' => trans($shortcut['name']),
                    'description' => trans($shortcut['description']),
                    'url' => $shortcut['url'],
                    'icons' => [
                        $icon
                    ]
                ];
            }
        }

        foreach (config('metatags.manifest.custom') as $tag => $value) {
            $basicManifest[$tag] = $value;
        }
        return $basicManifest;
    }

    public function render()
    {
        return "<?php \$config = (new \LaravelPWA\Services\ManifestService)->generate(); echo \$__env->make( 'laravelpwa::meta' , ['config' => \$config])->render(); ?>";
    }

}
