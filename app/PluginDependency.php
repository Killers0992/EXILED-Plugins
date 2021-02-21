<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Project;

class PluginDependency extends Model
{    

    protected $table = "exiled_plugins.plugins_dependencies";
    protected $guarded = [];

    protected $fillable = [
        'file_id',
        'target_file_id'
    ];

    public function file()
    {
        return $this->belongsTo(PluginFile::class, 'target_file_id', 'file_id');
    }

    protected $primaryKey = 'file_id';
    public $timestamps = false;
}
 