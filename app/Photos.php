<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    public $primaryKey="photoId";
    protected $table = "photos";
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany('App\Images','photoId','photoId')->select('uriKey');
    }
}
