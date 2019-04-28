<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    //
    public $primaryKey = "vidoeId";
    protected $table = "videos";
    protected $guarded = [];
}
