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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
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

    public function pluginList(Request $request)
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

    public function createPlugin(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'pluginname'                  => 'required|max:50',
                'plugincheck'                    => 'accepted'
            ],
            [
                'pluginname.required'        => 'You must provide plugin name.',
                'plugincheck.accepted'     => 'You must agree to plugin policy!'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $plugin = new Plugin();
        $plugin->name = $request->input('pluginname');
        $plugin->owner_steamid = Auth::user()->steamid;
        $plugin->creation_date = new DateTime();
        $plugin->last_update = new DateTime();
        $plugin->save();

        Storage::disk('local')->makeDirectory($plugin->id);
        Storage::disk('local')->makeDirectory($plugin->id.'/download');

        return redirect()->route('plugin.edit', ['id' => $plugin->id]);
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

    public function uploadFile(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->where('owner_steamid', '=', Auth::user()->steamid)->first();
        if (is_null($plugin)){
            return back()->with('error', 'Plugin not found!');
        }
        $validator = Validator::make($request->all(),
        [
            'exiledversion'                  => 'required|max:50',
            'type' => 'required|max:1',
            'changelog' => 'required|max:2000',
            'file' => 'required|max:25000',
            'version' => 'required|max:50'
        ],
        [
            'exiledversion.required'        => 'You must provide exiled version.',
            'type.required' => "FATAL ERROR",
            'changelog.required' => 'You must provide changelog.',
            'file.required' => 'You must provide file.',
            'version.required' => 'You must provide version.'
        ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $uploadedFile = $request->file;
        $filename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileex = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);

        $file = new PluginFile();
        $file->plugin_id = $plugin->id;
        $file->type = $request->input('type');
        $file->file_name = $filename;
        $file->file_extension = $fileex;
        $file->file_size = $uploadedFile->getSize();
        $file->upload_time = new DateTime();
        $file->exiled_version = $request->input('exiledversion');
        $file->version = $request->input('version');
        $file->changelog = $request->input('changelog');
        $file->save();       
        $uploadedFile->storeAs($plugin->id.'/download/'.$file->file_id, $filename.'.'.$fileex);
        $plugin->last_update = new DateTime();
        $plugin->latest_file_id = $file->file_id;
        $plugin->latest_exiled_version = $file->exiled_version;
        $plugin->save();

        return back()->with('success',' File uploaded!');
    }

    public function get_url_contents($url)
    {
        $ch = self::curl_init($url);

        $data = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (!curl_errno($ch)) {
            //check HTTP return code
            curl_close($ch);
            if ($info['http_code'] == 200) {
                return [
                    'success' => true,
                    'data' => $data,
                    'info' => $info
                ];
            } else {
                Log::error('Curl error for ' . $url . ': URL returned status code - ' . $info['http_code']);
                return [
                    'success' => false,
                    'message' => 'URL returned status code - ' . $info['http_code'],
                    'info' => $info
                ];
            }
        }

        $errors = curl_error($ch);
        //log the string return of the errors
        Log::error('Curl error for ' . $url . ': ' . $errors);
        curl_close($ch);
        return [
            'success' => false,
            'message' => $errors,
            'info' => $info
        ];
    }

    private function curl_init($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ExiledPlugins');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        return $ch;
    }

    /**
     * Uses Curl to get URL contents and returns hash
     * @param  String  $url  Url Location
     * @return array
     */
    public function get_remote_md5($url)
    {
        $checkFile = self::checkRemoteFile($url);

        if ($checkFile['success']) {
            $content = self::get_url_contents($url);
            if ($content['success']) {
                try {
                    $md5 = md5($content['data']);
                    return [
                        'success' => true,
                        'md5' => $md5,
                        'filesize' => $content['info']['download_content_length']
                    ];
                } catch (Exception $e) {
                    Log::error('Error hashing remote md5: ' . $e->getMessage());
                    return [
                        'success' => false,
                        'message' => $e->getMessage(),
                        'info' => $content['info'],
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => $content['message'],
                    'info' => $content['info'],
                ];
            }
        }

        return [
            'success' => false,
            'message' => $checkFile['message'],
            'info' => $checkFile['info']
        ];
    }

    public function checkRemoteFile($url)
    {
        $ch = self::curl_init($url);

        curl_setopt($ch, CURLOPT_NOBODY, true);

        curl_exec($ch);

        $info = curl_getinfo($ch);

        //check if there are any errors
        if (!curl_errno($ch)) {
            //check HTTP return code
            curl_close($ch);
            if ($info['http_code'] == 200 || $info['http_code'] == 405) {
                return ['success' => true, 'info' => $info];
            } else {
                return [
                    'success' => false,
                    'message' => 'URL returned status code - ' . $info['http_code'],
                    'info' => $info
                ];
            }
        }

        //log the string return of the errors
        $errors = curl_error($ch);
        Log::error('Curl error for ' . $url . ': ' . $errors);
        curl_close($ch);
        return ['success' => false, 'message' => $errors, 'info' => $info];
    }

    public function getHeaders($url)
    {
        $ch = self::curl_init($url);

        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $data = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (!curl_errno($ch)) {
            //check HTTP return code
            curl_close($ch);
            if ($info['http_code'] == 200 || $info['http_code'] == 405) {
                return ['success' => true, 'headers' => $data, 'info' => $info];
            } else {
                return [
                    'success' => false, 'message' =>
                        'Remote server did not return 200', 'info' => $info
                ];
            }
        }

        //log the string return of the errors
        $errors = curl_error($ch);
        Log::error('Curl error for ' . $url . ': ' . $errors);
        curl_close($ch);
        return ['success' => false, 'message' => $errors, 'info' => $info];
    }

    public function downloadFile(Request $request, $id, $fileid)
    {
        $plugin = Plugin::where('id', '=', $id)->first();
        if (is_null($plugin)){
            return back()->with('error', 'Plugin not found!');
        }
        $file = PluginFile::where('plugin_id', '=', $plugin->id)->where('file_id', '=', $fileid)->first();
        if (is_null($file)){
            return back()->with('error', 'Cant find that file');
        }
        $fileName = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix(). $id . '/download/'.$fileid.'/'.$file->file_name.'.'.$file->file_extension;
        if (!Storage::exists($fileName)){
            return back()->with('error', 'Cant find that file');
        }
        $file->downloads_count++;
        $file->save();
        $plugin->downloads_count++;
        $plugin->save();
        return response()->download($fileName);
    }

    public function deleteFile(Request $request, $id)
    {
        $plugin = Plugin::where('id', '=', $id)->where('owner_steamid', '=', Auth::user()->steamid)->first();
        if (is_null($plugin)){
            return back()->with('error', 'Plugin not found!');
        }
        $validator = Validator::make($request->all(),
        [
            'fileid'                  => 'required|max:300',
        ],
        [
            'fileid.required'        => 'FATAL ERROR'
        ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = PluginFile::find($request->input('fileid'));
        if (is_null($file)){
            return back()->with('error', 'Cant delete that file');
        }
        
        if ($file->plugin_id != $plugin->id)
        {
            return back()->with('error', 'That file is not owned by this plugin!');
        }

        $plugin->last_update = new DateTime();
        $oldid = $file->file_id;
        
        $file->delete();

        $fl = PluginFile::where('plugin_id', '=', $plugin->id)->orderBy('upload_time', 'DESC')->first();
        if ($plugin->latest_file_id == $oldid){
            if (is_null($fl)){
                $plugin->latest_exiled_version = '2.1.29';
                $plugin->latest_file_id = -1;
            }else{
                $plugin->latest_exiled_version = $fl->exiled_version;
                $plugin->latest_file_id = $fl->file_id;
            }
        }
        $plugin->save();

        Storage::deleteDirectory('/'.$plugin->id.'/download/'.$oldid);
        return back()->with('success', 'File removed!');

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

    public function deletePlugin(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'pluginname'                  => 'required|max:50',
            'pluginid' => 'required'
        ],
        [
            'pluginname.required'        => 'You must provide plugin name.',
            'pluginid.required' => "FATAL ERROR"
        ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $plugin = Plugin::where('id', '=', $request->input('pluginid'))->where('owner_steamid', '=', Auth::user()->steamid)->first();
        if (is_null($plugin)){
            return redirect()->route('home');
        }

        if ($plugin->name != $request->input('pluginname')){
            return back()->with('error', 'Plugin name is not correct.');
        }
        $files = PluginFile::where('plugin_id', '=', $plugin->id)->get();
        foreach($files as $file)
        {
            $file->delete();
        }

        $plugin->delete();
        return redirect()->route('home')->with('success', 'Plugin removed!');
    }

    public function editChangesPlugin(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'pluginname'                  => 'required|max:50',
            'pluginid'                    => 'required',
            'pluginimage'                 => 'required|max:150',
            'pluginsmalldescription'      => 'required|max:250',
            'plugindescription'           => 'required|max:2000',
            'category'                    => 'required'
        ],
        [
            'pluginname.required'        => 'You must provide plugin name.',
            'pluginimage.required'       => 'You must provide plugin image.',
            'pluginsmalldescription.required' => 'You must provide small description.',
            'plugindescription.required' => 'You must provide description.',
            'pluginid.required'          => 'FATAL ERROR',
            'category.required'          => 'FATAL ERROR'
        ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $plugin = Plugin::where('id', '=', $request->input('pluginid'))->where('owner_steamid', '=', Auth::user()->steamid)->first();
        if (is_null($plugin)){
            return redirect()->route('home')->with('error', 'Plugin with id '. $request->input('pluginid') . ' not found.');
        }
        $plugin->name = $request->input('pluginname');
        $plugin->image_url = $request->input('pluginimage');
        $plugin->source_url = $request->input('pluginsource');
        $plugin->wiki_url = $request->input('pluginwiki');
        $plugin->issues_url = $request->input('pluginissues');
        $plugin->description = $request->input('plugindescription');
        $plugin->small_description = $request->input('pluginsmalldescription');
        $plugin->category = $request->input('category');
        $plugin->last_update = new DateTime();
        $plugin->save();

        return back()->with('success', 'Plugin updated !');
    }
}
