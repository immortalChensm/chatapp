<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Recharge extends Model
{
    protected $table = "recharge";
    public $primaryKey = "id";
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }


}
