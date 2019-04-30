<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    //
    public $primaryKey = "videoId";
    protected $table = "videos";
    protected $guarded = [];
}
