<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Plugin extends Model
{
    protected $table = "exiled_plugins.plugins";
    protected $guarded = [];

    protected $fillable = [
        'id',
        'image_url',
        'name',
        'small_description',
        'description',
        'wiki_url',
        'issues_url',
        'source_url',
        'latest_file_id',
        'latest_exiled_version',
        'latest_version',
        'last_update',
        'creation_date',
        'downloads_count',
        'category',
        'webhook_url',
        'user_id'
    ];

    use HasTrixRichText;

    public function categoryobj()
    {
        return $this->belongsTo(PluginCategory::class, 'category', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(PluginFile::class);
    }
    
    protected $hidden = [
        'user_id',
        'webhook_url',
        'category'
    ];
    
    protected $with = ['user', 'files', 'categoryobj'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
 