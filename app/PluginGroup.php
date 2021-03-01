<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class PluginGroup extends Model
{
    protected $table = "exiled_plugins.plugins_groups";
    protected $guarded = [];

    protected $fillable = [
        'id',
        'group_name',
        'group_color',
        'all_perms',
        'delete_plugin',
        'edit_plugin',
        'upload_file'
    ];

    
    public $timestamps = false;
    protected $primaryKey = 'id';
}
 