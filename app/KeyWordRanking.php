<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyWordRanking extends Model
{
    //
    protected $table = "users_search";
    public $primaryKey = "id";
    protected $guarded = [];
}
