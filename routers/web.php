<?php

$router->get(config('seotools.manifest.manifest_url'), [\Turahe\SEOTools\Http\Controllers\PwaController::class, 'manifestJson'])->name('manifest');
$router->get('offline', [\Turahe\SEOTools\Http\Controllers\PwaController::class, 'offline']);
