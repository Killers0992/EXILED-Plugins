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
        'owner_steamid'
    ];

    use HasTrixRichText;

    public function getCategoryniceAttribute() {
        switch($this->category)
        {
            case 1:
                return '<abbr title="Features"><span class="badge bg-maroon">Features</span></abbr>';
            case 2:
                return '<abbr title="Utility"><span class="badge bg-teal">Utility</span></abbr>';
            case 3:
                return '<abbr title="Customization"><span class="badge bg-danger">Customization</span></abbr>';
            case 4:
                return '<abbr title="Reworks"><span class="badge bg-info">Reworks</span></abbr>';
            case 5:
                return '<abbr title="SCPs"><span class="badge bg-info">SCPs</span></abbr>';
            case 6:
                return '<abbr title="Dev Tools"><span class="badge bg-info">Dev Tools</span></abbr>';
            case 0:
            default:
                return '<abbr title="None"><span class="badge bg-gray">None</span></abbr>';
        }
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'owner_steamid', 'steamid');
    }

    public function files()
    {
        return $this->hasMany(PluginFile::class);
    }
    
    protected $hidden = [
        'owner_steamid'
    ];
    
    protected $with = ['user', 'files'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
 