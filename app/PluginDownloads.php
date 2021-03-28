<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Project;

class PluginDownloads extends Model
{    

    protected $table = "exiled_plugins.plugins_downloads";
    protected $guarded = [];

    protected $fillable = [
        'ip',
        'plugin_id',
        'file_id'
    ];

    protected $primaryKey = 'ip';
    public $timestamps = false;
}
 