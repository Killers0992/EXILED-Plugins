<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use App\Traits\HasPluginPermission;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;
    use HasPluginPermission;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTable("exiled_plugins.users");
    }

    protected $fillable = [
        'id', 'nickname', 'profile_url'
    ];

    protected $hidden = [
        'remember_token',
        'profile_url'
    ];    
    
    public $timestamps = false;
    protected $primaryKey = 'id';
}
 