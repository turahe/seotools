<?php


$router->get('manifest.json', [\Turahe\Metatags\Http\Controllers\ManifestServiceController::class, 'manifestJson']);
$router->get('offline', [\Turahe\Metatags\Http\Controllers\ManifestServiceController::class, 'offline']);
