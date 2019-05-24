<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    //
    protected $table = "reports";
    public $primaryKey = "id";
    protected $guarded = [];

    public function reasonName(){
        return $this->belongsTo('App\Reason','reasonId','id')->select('reason');
    }

    public function userName(){
        return $this->belongsTo('App\User','userId','id')->select('realName,name');
    }

}
