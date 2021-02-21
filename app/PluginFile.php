<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Project;

class PluginFile extends Model
{    

    protected $table = "exiled_plugins.plugins_files";
    protected $guarded = [];

    protected $fillable = [
        'plugin_id',
        'file_id',
        'type',
        'file_name',
        'file_extension',
        'file_size',
        'upload_time',
        'exiled_version',
        'version',
        'downloads_count',
        'changelog'
    ];

    public function plugin()
    {
        return $this->belongsTo(Plugin::class, 'plugin_id', 'id');
    }

    public function dependencies()
    {
        return $this->hasMany(PluginDependency::class);
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

    protected $primaryKey = 'file_id';
    public $timestamps = false;
}
 