<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportGroup extends Model
{
    //
    protected $table = "report_groups";
    public $primaryKey = "id";
    protected $guarded = [];

    public function reportGroupName(){
        return $this->belongsTo('App\Groups','groupId','id')->select('Name');
    }

    public function userName(){
        return $this->belongsTo('App\User','userId','userId')->select(['realName','name']);
    }

}
