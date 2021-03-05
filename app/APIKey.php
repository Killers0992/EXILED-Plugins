<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class APIKey extends Model
{    
    public function __construct()
    {
        parent::__construct();
        $this->setTable("exiled_plugins.plugins_apikeys");
    }

    protected $fillable = [
        'owner', 'api_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner', 'steamid');
    }
    public $timestamps = false;
    protected $primaryKey = 'owner';
}
 