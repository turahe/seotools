<?php

namespace Turahe\SEOTools\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Turahe\SEOTools\Contracts\Pwa as ManifestServices;

/**
 * Generate Manifest Json and offline pages
 */
class PwaController
{
    /**
     * @var ManifestServices
     */
    private $manifest;

    /**
     * @param ManifestServices $manifest
     */
    public function __construct(ManifestServices $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function manifestJson(): JsonResponse
    {
        $output = $this->manifest->generate();
        return response()->json($output);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function offline()
    {
        return view('seotools::offline');
    }
}
