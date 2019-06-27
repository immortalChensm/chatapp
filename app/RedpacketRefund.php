<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class RedpacketRefund extends Model
{
    protected $table = "users_refund_redpackets";
    public $primaryKey = "id";
    protected $guarded = [];

    /**
     * 红包退还用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','userId','userId')->select(["name","realName"]);
    }

    public function redpacket()
    {

        return $this->belongsTo('App\RedPackets','redPacketId','id')->select(["money","message","num","created_at"]);
    }

}
