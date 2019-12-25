<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    //
    protected $table = "agreement";
    public $primaryKey = "id";
    protected $guarded = [];

    public $timestamps = false;

    public function userName(){
        return $this->belongsTo('App\User','userId','userId')->select(['realName','name']);
    }
}
