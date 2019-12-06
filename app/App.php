<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    //
    protected $table = "app";
    public $primaryKey = "id";
    protected $guarded = [];
}
