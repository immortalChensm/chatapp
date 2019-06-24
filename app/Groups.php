<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Groups extends Model
{
    protected $table = "groups";
    public $primaryKey = "id";
    protected $guarded = [];

}
