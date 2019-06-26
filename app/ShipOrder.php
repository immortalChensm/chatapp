<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class ShipOrder extends Model
{
    protected $table = "users_ships_order";
    public $primaryKey = "id";
    protected $guarded = [];

    public function buyer()
    {
        return $this->belongsTo('App\User','userId','userId')->value("name");
    }

    public function seller()
    {
        return $this->belongsTo('App\User','sellerUserId','userId')->value("name");
    }

}
