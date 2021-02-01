<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Plugin extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];
    public function __construct()
    {
        parent::__construct();
        $this->setTable("exiled_plugins.plugins");
    }

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
                return '<abbr title="Reworks"><span class="badge bg-teal">Reworks</span></abbr>';
            case 3:
                return '<abbr title="SCPs"><span class="badge bg-danger">SCPs</span></abbr>';
            case 4:
                return '<abbr title="External"><span class="badge bg-info">External</span></abbr>';
            case 0:
            default:
                return '<abbr title="None"><span class="badge bg-gray">None</span></abbr>';
        }
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'owner_steamid', 'steamid');
    }

    public $timestamps = false;
    protected $primaryKey = 'id';
}
 