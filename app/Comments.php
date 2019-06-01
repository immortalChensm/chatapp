<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table = "comments";
    public $primaryKey = "id";
    protected $guarded = [];

    public function reply(){
        return $this->hasMany('App\Reply','commentId','id');
    }


}
