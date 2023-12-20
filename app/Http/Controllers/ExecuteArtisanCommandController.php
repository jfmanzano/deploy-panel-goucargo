<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ExecuteArtisanCommandController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $command)
    {
        $params = $request->all();
        Artisan::call($command, $params);
        $output = Artisan::output();
        return $output;
    }
}
