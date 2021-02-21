<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PluginFile;
use DateTime;
use App\Plugin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PluginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function jsonplugins(Request $request)
    {
        $plugins = Plugin::select('id','name','image_url')->where('name', 'LIKE', '%'.$request->input('q').'%')->get();
        $arr = array();
        foreach($plugins as $pl)
        {
            $files = PluginFile::where('plugin_id', '=', $pl->id)->orderBy('upload_time', 'DESC')->get();
            
            foreach($files as $file)
            {
                array_push($arr, [ 'id' => $file->file_id, 'version' => $file->version, 'name' => $pl->name, 'image' => $pl-> image_url ]);
            }
        }
        return response()->json($arr, 200);
    }

    public function pluginList(Request $request)
    {
        $query = $request->input('query');
        if ($query != null)
        {
            $plugins = Plugin::orderBy('downloads_count', 'DESC')->where('name', 'LIKE', '%'.$query.'%')->paginate(10);
            $count = Plugin::orderBy('downloads_count', 'DESC')->where('name', 'LIKE', '%'.$query.'%')->count();
        }else{
            $plugins = Plugin::orderBy('downloads_count', 'DESC')->paginate(10);
            $count = Plugin::get()->count();
        }
        return view('home', compact('plugins', 'count'));
    }

    public function myPluginList(Request $request)
    {
        $query = $request->input('query');
        if ($query != null)
        {
            $plugins = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('name', 'LIKE', '%'.$query.'%')->paginate(10);
            $count = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('name', 'LIKE', '%'.$query.'%')->count();
        }else{
            $count = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->count();
            $plugins = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->paginate(10);
        }
        return view('myplugins', compact('plugins', 'count'));
    }

    public function addPlugin(Request $request)
    {
        return view('addplugin');
    }

    public function editPlugin(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->where('owner_steamid', '=', Auth::user()->steamid)->first();
        if (is_null($plugin)){
            return redirect()->route('home');
        }

        return view('editplugin', compact('plugin'));
    }

    public function viewPlugin(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->first();
        if (is_null($plugin)){
            return back()->with('error', 'Plugin not found.');
        }
        return view('viewplugin', compact('plugin'));
    }
    public function viewPluginFiles(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->first();
        if (is_null($plugin)){
            return back()->with('error', 'Plugin not found.');
        }
        $files = PluginFile::where('plugin_id', '=', $plugin->id)->orderBy('upload_time', 'DESC')->paginate(5);
        
        return view('viewpluginfiles', compact('plugin', 'files'));
    }
}
