<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Group extends Model
{
    protected $table = "exiled_plugins.groups";
    protected $guarded = [];

    protected $fillable = [
        'id',
        'group_name',
        'group_color',
        'all_perms',
        'delete_plugin',
        'delete_plugin_admin',
        'create_plugin',
        'edit_plugin',
        'edit_plugin_admin',
        'upload_file',
        'upload_file_admin',
        'view_users',
        'view_groups'
    ];

    
    public $timestamps = false;
    protected $primaryKey = 'id';
}
 