<?php

namespace Turahe\Metatags\Http\Controllers;

use Turahe\Metatags\Manifest;

class ManifestServiceController
{
    public function manifestJson()
    {
        $output = (new Manifest())->generate();
        return response()->json($output);
    }

    public function offline(){
        return view('metatags::offline')->extend('app.layout');
    }

}
