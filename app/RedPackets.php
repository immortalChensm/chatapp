<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class RedPackets extends Model
{
    protected $table = "redpacket";
    public $primaryKey = "id";
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }


}
