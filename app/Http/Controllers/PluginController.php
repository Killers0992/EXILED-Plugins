<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PluginFile;
use DateTime;
use App\Plugin;
use App\User;
use App\Group;
use App\PluginGroup;
use App\PluginCategory;
use App\PluginMember;
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

    public function pluginmembers(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->first();
        if (is_null($plugin)){
            return back()->with('error', 'Plugin not found.');
        }
        $members = PluginMember::where('plugin_id', '=', $plugin->id)->paginate(5);
        $groups = PluginGroup::all();

        return view('viewpluginmembers', compact('plugin', 'members', 'groups'));
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

    public function jsonusers(Request $request)
    {
        $users = User::select('steamid','nickname','profile_url')->where('nickname', 'LIKE', '%'.$request->input('q').'%')->get();
        $arr = array();
        foreach($users as $user)
        {
            array_push($arr, [ 'id' => $user->steamid, 'name' => $user->nickname, 'image' => $user->profile_url ]);
        }
        return response()->json($arr, 200);
    }

    public function users(Request $request)
    {
        $query = $request->input('query');
        if ($query != null)
        {
            $users = User::where('nickname', 'LIKE', '%'.$query.'%')->orderBy('group', 'DESC')->paginate(10);
            $count = User::where('nickname', 'LIKE', '%'.$query.'%')->count();
        }else{
            $users = User::orderBy('group', 'DESC')->paginate(10);
            $count = User::count();
        }
        if (Auth::user()->groupe->all_perms == 0 && Auth::user()->groupe->view_users == 0)
        {
            return back()->with('error', 'No permissions.');
        }
        return view('users', compact('users', 'count'));
    }

    public function groups(Request $request)
    {
        $query = $request->input('query');
        if ($query != null)
        {
            $groups = Group::where('group_name', 'LIKE', '%'.$query.'%')->orderBy('id', 'DESC')->paginate(10);
            $count = Group::where('group_name', 'LIKE', '%'.$query.'%')->count();
        }else{
            $groups = Group::orderBy('id', 'DESC')->paginate(10);
            $count = Group::count();
        }
        if (Auth::user()->groupe->all_perms == 0 && Auth::user()->groupe->view_groups == 0)
        {
            return back()->with('error', 'No permissions.');
        }
        return view('groups', compact('groups', 'count'));
    }

    public function pluginList(Request $request)
    {
        $search = $request->input('query');
        $filter = $request->input('filter');
        if($filter != '-1' && $filter != null)
        { 
            if($search != null)
            {
                $plugins = Plugin::where('category', '=', $filter)->where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->paginate(25);
                $count = Plugin::where('category', '=', $filter)->where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->count();
            } 
            else
            {
                $plugins = Plugin::where('category', '=', $filter)->orderBy('downloads_count', 'DESC')->paginate(25);
                $count = Plugin::where('category', '=', $filter)->orderBy('downloads_count', 'DESC')->count();
            }
        } 
        elseif ($search != null)
        {
            $plugins = Plugin::where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->paginate(25);  
            $count = Plugin::where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->count();  
        } 
        else 
        {
            $plugins = Plugin::where('name', '!=', '')->orderBy('downloads_count', 'DESC')->paginate(25);
            $count = Plugin::where('name', '!=', '')->orderBy('downloads_count', 'DESC')->count();
        }

        $categories = PluginCategory::all();
        return view('home', compact('plugins', 'count', 'categories'));
    }

    public function myPluginList(Request $request)
    {
        $search = $request->input('query');
        $filter = $request->input('filter');
        if($filter != '-1' && $filter != null)
        { 
            if($search != null)
            {
                $plugins = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('category', '=', $filter)->where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->paginate(25);
                $count = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('category', '=', $filter)->where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->count();
            } 
            else
            {
                $plugins = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('category', '=', $filter)->orderBy('downloads_count', 'DESC')->paginate(25);
                $count = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('category', '=', $filter)->orderBy('downloads_count', 'DESC')->count();
            }
        } 
        elseif ($search != null)
        {
            $plugins = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->paginate(25);  
            $count = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('name', 'LIKE', '%'.$search.'%')->orderBy('downloads_count', 'DESC')->count();  
        } 
        else 
        {
            $plugins = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('name', '!=', '')->orderBy('downloads_count', 'DESC')->paginate(25);
            $count = Plugin::where('owner_steamid', '=', Auth::user()->steamid)->where('name', '!=', '')->orderBy('downloads_count', 'DESC')->count();
        }

        $categories = PluginCategory::all();
        return view('myplugins', compact('plugins', 'count', 'categories'));
    }

    public function addPlugin(Request $request)
    {
        if (Auth::user()->groupe->all_perms == 0 && Auth::user()->groupe->create_plugin == 0)
        {
            return back()->with('error', 'No permissions.');
        }
        return view('addplugin');
    }

    public function editPlugin(Request $request, $id)
    {
        if (Auth::user()->groupe->all_perms == 0 && Auth::user()->groupe->edit_plugin == 0 && Auth::user()->groupe->edit_plugin_admin == 0)
        {
            return back()->with('error', 'No permissions.');
        }

        if (Auth::user()->groupe->edit_plugin_admin == 1 || Auth::user()->groupe->all_perms == 1)
        {
            $plugin = Plugin::where('id', '=', $id)->first();
        }
        else
        {
            $plugin = Plugin::where('id', '=', $id)->where('owner_steamid', '=', Auth::user()->steamid)->first();
        }
        
        if (is_null($plugin)){
            return redirect()->route('home');
        }

        $categories = PluginCategory::all();

        return view('editplugin', compact('plugin', 'categories'));
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
