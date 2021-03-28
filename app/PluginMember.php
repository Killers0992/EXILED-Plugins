<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class PluginMember extends Model
{
    protected $table = "exiled_plugins.plugins_members";
    protected $guarded = [];

    protected $fillable = [
        'id',
        'steamid',
        'plugin_id',
        'group'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'steamid', 'id');
    }

    public function groupe()
    {
        return $this->belongsTo(PluginGroup::class, 'group', 'id');
    }

    public $timestamps = false;
    protected $primaryKey = 'id';
}
 