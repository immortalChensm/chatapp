<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    //
    protected $table = "report_reasons";
    public $primaryKey = "id";
    protected $guarded = [];
}
