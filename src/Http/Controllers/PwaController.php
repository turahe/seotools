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
     * @param ManifestServices $manifest
     */
    public function __construct(private ManifestServices $manifest)
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function manifestJson(): JsonResponse
    {
        $output = $this->manifest->manifestJson();

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
