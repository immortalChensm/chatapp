<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Transfer extends Model
{
    protected $table = "transfer";
    public $primaryKey = "id";
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }

    public function who()
    {
        return $this->belongsTo('App\User','whoId','userId')->select(["name","realName"]);
    }

}
