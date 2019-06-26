<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class UserRedPackets extends Model
{
    protected $table = "users_redpacket";
    public $primaryKey = "id";
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }

}
