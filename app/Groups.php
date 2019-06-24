<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\User;
class Groups extends Authenticatable
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
