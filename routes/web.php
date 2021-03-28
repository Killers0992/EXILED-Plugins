<?php

use Illuminate\Support\Facades\Route;

Route::get('/error/403', function () {
    return view('403');
})->name('accessdenied');

#Log activity group
Route::group(['middleware' => 'activity'], function (){
    #Plugins
    Route::get('/', 'PluginController@pluginList')->name('home');
    
    #Profile
    Route::get('profile/{userid}', 'PluginController@profile')->name('profile');

    #Auth group
    Route::group(['middleware' => 'auth'], function (){
        #User/Plugin selector
        Route::get('plugins/json', 'PluginController@jsonplugins')->name('plugins.json');
        Route::get('users/json', 'PluginController@jsonusers')->name('users.json');
        
        #Plugins - Add new plugin
        Route::group(['middleware' => ['permission:create.plugin']], function(){
            Route::get('plugin/add', 'PluginController@addPlugin')->name('plugin.addindex');
            Route::post('plugin/create', 'PluginManagment@createPlugin')->name('plugin.create');
        });

        #Plugins - Manage
        Route::get('myplugins', 'PluginController@myPluginList')->name('plugin.list')->middleware('permission:view.ownplugins');
        Route::post('plugin/delete', 'PluginManagment@deletePlugin')->name('plugin.delete');
        
        #Plugins - Edit
        Route::get('plugin/{id}/edit', 'PluginController@editPlugin')->name('plugin.edit');
        Route::post('plugin/editchanges', 'PluginManagment@editChangesPlugin')->name('plugin.editchanges');
       
        #Plugins - Files
        Route::post('plugin/{id}/files/upload', 'PluginManagment@uploadFile')->name('plugin.upload.file');
        Route::post('plugin/{id}/files/delete', 'PluginManagment@deleteFile')->name('plugin.delete.file');
        
        #Plugins - Members
        Route::post('plugin/{id}/members/add', 'PluginManagment@addMember')->name('plugin.members.add')->middleware('role:admin');

        #Auth
        Route::post('logout', 'AuthController@logout')->name('logout');

        #ApiKey
        Route::group(['middleware' => ['permission:view.api']], function(){
            Route::get('apikey', 'PluginAPI@viewApiKey')->name('api.key');
            Route::post('apikey/create', 'PluginAPI@createApiKey')->name('api.create')->middleware('permission:create.apikey');
            Route::post('apikey/delete', 'PluginAPI@deleteApiKey')->name('api.delete')->middleware('permission:delete.apikey');
        });

        
        #Admin stuff
        Route::get('users', 'PluginController@users')->name('users')->middleware('permission:view.users');
    });

    #Plugins - Main page
    Route::get('plugin/{id}', 'PluginController@viewPlugin')->name('plugin.view');
    Route::get('plugin/{id}/files', 'PluginController@viewPluginFiles')->name('plugin.view.files');
    Route::get('plugin/{id}/download/{fileid}', 'PluginManagment@downloadFile')->name('plugin.download.file');
    Route::get('plugin/{id}/members', 'PluginController@pluginmembers')->name('plugin.view.members');



    #Auth
    Route::get('auth/steam', 'AuthController@redirectToSteam')->name('auth.steam');
    Route::get('auth/steam/handle', 'AuthController@handle')->name('auth.steam.handle');

    #Api
    Route::get('api/plugins/{id}', 'PluginAPI@pluginsOnce')->name('api.plugins.once')->middleware('activity');
    Route::get('api/plugins', 'PluginAPI@plugins')->name('api.plugins')->middleware('activity');
});


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
