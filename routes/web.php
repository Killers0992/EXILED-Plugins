<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PluginController@index')->name('home');


Route::get('/error/403', function () {
    return view('403');
})->name('accessdenied');


Route::get('plugin/add', 'PluginController@addPlugin')->name('plugin.addindex')->middleware('auth');
Route::get('plugin/{id}/edit', 'PluginController@editPlugin')->name('plugin.edit')->middleware('auth');
Route::post('plugin/delete', 'PluginController@deletePlugin')->name('plugin.delete')->middleware('auth');
Route::post('plugin/editchanges', 'PluginController@editChangesPlugin')->name('plugin.editchanges')->middleware('auth');
Route::post('plugin/create', 'PluginController@createPlugin')->name('plugin.create')->middleware('auth');
Route::get('plugin/{id}', 'PluginController@viewPlugin')->name('plugin.view');
Route::get('plugin/{id}/files', 'PluginController@viewPluginFiles')->name('plugin.view.files');
Route::post('plugin/{id}/files/upload', 'PluginController@uploadFile')->name('plugin.upload.file')->middleware('auth');
Route::post('plugin/{id}/files/delete', 'PluginController@deleteFile')->name('plugin.delete.file')->middleware('auth');
Route::get('plugin/{id}/download/{fileid}', 'PluginController@downloadFile')->name('plugin.download.file');
Route::get('myplugins', 'PluginController@pluginList')->name('plugin.list')->middleware('auth');

Route::get('auth/steam', 'AuthController@redirectToSteam')->name('auth.steam');
Route::get('auth/steam/handle', 'AuthController@handle')->name('auth.steam.handle');
Route::post('logout', 'AuthController@logout')->name('logout');
