<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportUsers extends Model
{
    //
    protected $table = "users_reports";
    public $primaryKey = "id";
    protected $guarded = [];

    public function reportUserName(){
        return $this->belongsTo('App\User','reportedUserId','userId')->select(['realName','name']);
    }

    public function userName(){
        return $this->belongsTo('App\User','userId','userId')->select(['realName','name']);
    }

}
