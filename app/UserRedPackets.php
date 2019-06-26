<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class UserRedPackets extends Model
{
    protected $table = "users_redpacket";
    public $primaryKey = "id";
    protected $guarded = [];

    /**
     * 红包发送者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User','sendUserId','userId')->select(["name","realName"]);
    }

    /**
     * 抢到红包的人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recver()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }

    /**
     * 红包发送时间
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sendDate()
    {
        return $this->belongsTo('App\RedPackets','redpacketid','id')->select("created_at");
    }

}
