<?php

use Illuminate\Support\Facades\Route;

Route::get('/error/403', function () {
    return view('403');
})->name('accessdenied');

#Plugins
Route::get('/', 'PluginController@pluginList')->name('home')->middleware('activity');

Route::get('plugins/json', 'PluginController@jsonplugins')->name('plugins.json')->middleware('activity');
Route::get('users/json', 'PluginController@jsonusers')->name('users.json')->middleware('activity');

#Plugins - Add new plugin
Route::get('plugin/add', 'PluginController@addPlugin')->name('plugin.addindex')->middleware('auth')->middleware('activity');
Route::post('plugin/create', 'PluginManagment@createPlugin')->name('plugin.create')->middleware('auth')->middleware('activity');

#Plugins - Manage
Route::get('myplugins', 'PluginController@myPluginList')->name('plugin.list')->middleware('auth')->middleware('activity');
Route::post('plugin/delete', 'PluginManagment@deletePlugin')->name('plugin.delete')->middleware('auth')->middleware('activity');
Route::post('plugin/editchanges', 'PluginManagment@editChangesPlugin')->name('plugin.editchanges')->middleware('auth')->middleware('activity');

#Plugins - Main page
Route::get('plugin/{id}', 'PluginController@viewPlugin')->name('plugin.view')->middleware('activity');
Route::get('plugin/{id}/edit', 'PluginController@editPlugin')->name('plugin.edit')->middleware('auth')->middleware('activity');
Route::get('plugin/{id}/files', 'PluginController@viewPluginFiles')->name('plugin.view.files')->middleware('activity');
Route::get('plugin/{id}/download/{fileid}', 'PluginManagment@downloadFile')->name('plugin.download.file')->middleware('activity');
Route::post('plugin/{id}/files/upload', 'PluginManagment@uploadFile')->name('plugin.upload.file')->middleware('auth')->middleware('activity');
Route::post('plugin/{id}/files/delete', 'PluginManagment@deleteFile')->name('plugin.delete.file')->middleware('auth')->middleware('activity');
Route::get('plugin/{id}/members', 'PluginController@pluginmembers')->name('plugin.view.members')->middleware('activity');
Route::post('plugin/{id}/members/add', 'PluginManagment@addMember')->name('plugin.members.add')->middleware('auth')->middleware('activity');

#Auth
Route::get('auth/steam', 'AuthController@redirectToSteam')->name('auth.steam')->middleware('activity');
Route::get('auth/steam/handle', 'AuthController@handle')->name('auth.steam.handle')->middleware('activity');
Route::post('logout', 'AuthController@logout')->name('logout')->middleware('activity');

#Api
Route::get('api/plugins', 'PluginAPI@plugins')->name('api.plugins')->middleware('activity');

#Admin stuff
Route::get('groups', 'PluginController@groups')->name('groups')->middleware('auth')->middleware('activity');
Route::get('users', 'PluginController@users')->name('users')->middleware('auth')->middleware('activity');

//Logging Stuff
Route::group(['prefix' => 'activity', 'namespace' => '\jeremykenedy\LaravelLogger\App\Http\Controllers', 'middleware' => ['auth', 'activity']], function () {

    // Dashboards
    Route::get('/', 'LaravelLoggerController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LaravelLoggerController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LaravelLoggerController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LaravelLoggerController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LaravelLoggerController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LaravelLoggerController@restoreClearedActivityLog'])->name('restore-activity');
});
