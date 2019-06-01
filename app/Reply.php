<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    protected $table = "reply_comments";
    public $primaryKey = "id";
    protected $guarded = [];
}
