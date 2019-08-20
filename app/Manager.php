<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //
    protected $table = "managers";
    protected $guarded = [];

    public $primaryKey = "userId";

    public $timestamps = false;

}
