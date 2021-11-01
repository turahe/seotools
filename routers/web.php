<?php

$router->get('/manifest.json', [\Turahe\SEOTools\Http\Controllers\PwaController::class, 'manifestJson'])->name('manifest');
$router->get('/offline/', [\Turahe\SEOTools\Http\Controllers\PwaController::class, 'offline']);
