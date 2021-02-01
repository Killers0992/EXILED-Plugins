<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Project;

class PluginFile extends Authenticatable
{
    use Notifiable;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTable("exiled_plugins.plugins_files");
    }

    protected $fillable = [
        'plugin_id',
        'file_id',
        'type',
        'file_name',
        'file_size',
        'file_url',
        'upload_time',
        'exiled_version',
        'version',
        'downloads_count',
        'changelog',
        'dependency_plugins'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'plugin_id', 'id');
    }
    
    public function getTypeNiceAttribute() {
        switch($this->type)
        {
            case 0:
                return '<abbr title="Release"><span class="badge bg-success">R</span></abbr>';
            case 1:
                return '<abbr title="Beta"><span class="badge bg-info">B</span></abbr>';
            case 2:
                return '<abbr title="Alpha"><span class="badge bg-warning">A</span></abbr>';
        }
    }

    public function getFileSizeniceAttribute($unit = "")
	{
		$size = $this->file_size;
		if( (!$unit && $size >= 1<<30) || $unit == "GB")
			return number_format($size/(1<<30),2)." GB";
		if( (!$unit && $size >= 1<<20) || $unit == "MB")
			return number_format($size/(1<<20),2)." MB";
		if( (!$unit && $size >= 1<<10) || $unit == "KB")
			return number_format($size/(1<<10),2)." KB";
		return number_format($size)." bytes";
	}

    public $timestamps = false;
    protected $primaryKey = 'plugin_id';
}
 