<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class PluginCategory extends Model
{
    protected $table = "exiled_plugins.plugins_categories";
    protected $guarded = [];

    protected $fillable = [
        'id',
        'category_name',
        'category_color'
    ];

    public function getCategoryNiceAttribute() {
        return '<abbr title="'.$this->category_name.'"><span class="badge bg-'.$this->category_color.'">'.$this->category_name.'</span></abbr>';
    }

    
    public $timestamps = false;
    protected $primaryKey = 'id';
}
 