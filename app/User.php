<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTable("exiled_plugins.users");
    }

    protected $fillable = [
        'steamid', 'nickname', 'profile_url'
    ];


    protected $hidden = [
        'remember_token'
    ];

    public $timestamps = false;
    protected $primaryKey = 'steamid';
}
 