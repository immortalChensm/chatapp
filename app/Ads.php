<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //
    public $primaryKey="id";
    protected $table = "ads";
    protected $guarded = [];
    public $timestamps = false;
}
