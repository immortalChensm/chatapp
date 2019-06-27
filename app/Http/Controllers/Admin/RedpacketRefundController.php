<?php

namespace App\Http\Controllers\Admin;

use App\RedpacketRefund;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedpacketRefundController extends Controller
{
    //
    function index()
    {
        return view("admin.redpacket.refund");
    }

    function orders(Request $request,RedpacketRefund $redpacketRefund)
    {
        return $this->models(...[$request,$redpacketRefund,function (&$searchItem)use($request){
            if (!empty($request->query->get('sender'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('sender')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName = property_exists($item->user,'realName')?$item->user->realName:$item->user->name;
            $item->sendMoney = $item->redpacket->sendMoney;
            $item->message = $item->redpacket->message;
            $item->num = $item->redpacket->num;
            $item->refundMoney = $item->money;
            $item->refundDate = date("Y-m-d H:i:s", strtotime($item->created_at));
            $item->createdDate = date("Y-m-d H:i:s", strtotime($item->redpacket->created_at));
        }]);
    }

}
