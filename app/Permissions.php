<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    //
    protected $table = "permissions";
    public $primaryKey = "id";
    protected $guarded = [];
}
