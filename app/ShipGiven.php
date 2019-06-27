<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class ShipGiven extends Model
{
    protected $table = "users_ship_give";
    public $primaryKey = "id";
    protected $guarded = [];

    /**
     * 赠送人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }

    /**
     * 被赠送人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function giver()
    {
        return $this->belongsTo('App\User','givenUserId','userId')->select(["name","realName"]);
    }

}
