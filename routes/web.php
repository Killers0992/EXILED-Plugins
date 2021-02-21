<?php

use Illuminate\Support\Facades\Route;

Route::get('/error/403', function () {
    return view('403');
})->name('accessdenied');

#Plugins
Route::get('/', 'PluginController@pluginList')->name('home');

Route::get('plugins/json', 'PluginController@jsonplugins')->name('plugins.json');

#Plugins - Add new plugin
Route::get('plugin/add', 'PluginController@addPlugin')->name('plugin.addindex')->middleware('auth');
Route::post('plugin/create', 'PluginManagment@createPlugin')->name('plugin.create')->middleware('auth');

#Plugins - Manage
Route::get('myplugins', 'PluginController@myPluginList')->name('plugin.list')->middleware('auth');
Route::post('plugin/delete', 'PluginManagment@deletePlugin')->name('plugin.delete')->middleware('auth');
Route::post('plugin/editchanges', 'PluginManagment@editChangesPlugin')->name('plugin.editchanges')->middleware('auth');

#Plugins - Main page
Route::get('plugin/{id}', 'PluginController@viewPlugin')->name('plugin.view');
Route::get('plugin/{id}/edit', 'PluginController@editPlugin')->name('plugin.edit')->middleware('auth');
Route::get('plugin/{id}/files', 'PluginController@viewPluginFiles')->name('plugin.view.files');
Route::get('plugin/{id}/download/{fileid}', 'PluginManagment@downloadFile')->name('plugin.download.file');
Route::post('plugin/{id}/files/upload', 'PluginManagment@uploadFile')->name('plugin.upload.file')->middleware('auth');
Route::post('plugin/{id}/files/delete', 'PluginManagment@deleteFile')->name('plugin.delete.file')->middleware('auth');

#Auth
Route::get('auth/steam', 'AuthController@redirectToSteam')->name('auth.steam');
Route::get('auth/steam/handle', 'AuthController@handle')->name('auth.steam.handle');
Route::post('logout', 'AuthController@logout')->name('logout');

#Api
Route::get('api/plugins', 'PluginAPI@plugins')->name('api.plugins');