<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PluginFile;
use DateTime;
use App\Plugin;
use App\APIKey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function viewApiKey(Request $request)
    {
        $apiKey = APIKey::where('owner', '=', Auth::user()->id)->first();
        return view('apikey', compact('apiKey'));
    }

    public function createApiKey(Request $request)
    {
        $apiKey = APIKey::where('owner', '=', Auth::user()->id)->first();
        if (!is_null($apiKey)){
            $apiKey->api_key = Str::random(32);
            $apiKey->save();
        }
        else{
            $apiKey = new APIKey();
            $apiKey->owner = Auth::user()->id;
            $apiKey->api_key = Str::random(32);
            $apiKey->save();
        }
        return back()->with('success',' API Key created!');
    }

    public function deleteApiKey(Request $request)
    {
        $apiKey = APIKey::where('owner', '=', Auth::user()->id)->first();
        if (!is_null($apiKey)){
            $apiKey->delete();
        }
        return back()->with('success',' API Key deleted!');
    }

    public function plugins(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'apikey'                  => 'required',
        ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid API key.'], 404);
        }
        $apiKey = APIKey::where('api_key', '=', $request->input('apikey'))->first();
        if (is_null($apiKey)){
            return response()->json(['error' => 'Invalid API key.'], 404);
        }

        $plugins = Plugin::all();
        $arr = array();
        header('Content-Type: application/json');
        foreach($plugins as $pl)
        {
            $pld = json_decode($pl->toJson());
            array_push($arr, $pld);
        }
        return response()->json(['success' => $arr], 200);
    }

    public function pluginsOnce(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->first();
        if (is_null($plugin)){
            return response()->json(['error' => 'Plugin not found.'], 404);
        }
        $arr = (object) [ 
            'latest_version' => $plugin->latest_version,
            'latest_exiled_version' => $plugin->latest_exiled_version,
            'latest_download_link' => $plugin->latest_file_id == -1 ? '' : route('plugin.download.file', ['id' => $plugin->id, 'fileid' => $plugin->latest_file_id])
        ];
        return response()->json(['success' => $arr], 200);
    }
}
