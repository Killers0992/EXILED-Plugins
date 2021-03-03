<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PluginFile;
use DateTime;
use App\Plugin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PluginAPI extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function plugins(Request $request)
    {
        return response('bruh', 200);
        $plugins = Plugin::all();
        $arr = array();
        header('Content-Type: application/json');
        foreach($plugins as $pl)
        {
            $pld = json_decode($pl->toJson());
            $data = PluginFile::where('plugin_id', '=', $pl->id)->get();
            array_push($arr, $pld);
        }
        return response()->json($arr, 200);
    }
}
