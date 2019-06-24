<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Groups extends Model
{
    use Notifiable;

    protected $table = "groups";
    public $primaryKey = "id";

    protected $guarded = [];

    function user()
    {
        return $this->hasOne('App\Users',"Owner_Account","userId")->select(['name','realName']);
    }
}
