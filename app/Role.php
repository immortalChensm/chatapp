<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = "roles";
    public $primaryKey = "id";
    protected $guarded = [];
    public $timestamps = false;
}
