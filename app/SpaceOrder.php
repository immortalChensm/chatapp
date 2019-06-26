<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class SpaceOrder extends Model
{
    protected $table = "users_space_order";
    public $primaryKey = "id";
    protected $guarded = [];

    public function buyer()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }

}
