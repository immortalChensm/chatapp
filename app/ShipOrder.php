<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class ShipOrder extends Model
{
    protected $table = "users_ships_order";
    public $primaryKey = "id";
    protected $guarded = [];

    function buyer()
    {
        return $this->belongsTo('\App\Users','userId','id')->value("name");
    }

    function seller()
    {
        return $this->belongsTo('\App\Users','sellerUserId','id')->value("name");
    }

}
