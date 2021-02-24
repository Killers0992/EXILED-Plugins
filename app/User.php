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
        'steamid', 'nickname', 'group', 'profile_url'
    ];


    protected $hidden = [
        'remember_token',
        'profile_url'
    ];    
    
    public function groupe()
    {
        return $this->belongsTo(Group::class, 'group', 'id');
    }

    public $timestamps = false;
    protected $primaryKey = 'steamid';
}
 