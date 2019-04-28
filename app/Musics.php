<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Musics extends Model
{
    //
    public $primaryKey = "musicId";
    protected $table = "musics";
    protected $guarded = [];
}
