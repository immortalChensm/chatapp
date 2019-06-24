<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Groups extends Model
{
    protected $table = "groups";
    public $primaryKey = "id";
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\Users',"Owner_Account","userId")->select(['name','realName']);
    }
}
