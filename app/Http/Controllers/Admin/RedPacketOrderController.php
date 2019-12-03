<?php

namespace App\Http\Controllers\Admin;


use App\RedPackets;
use App\User;
use App\UserRedPackets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedPacketOrderController extends Controller
{
    //
    function index()
    {
        return view("admin.redpacket.index");
    }

    function orders(Request $request,RedPackets $redPackets)
    {
        return $this->models(...[$request,$redPackets,function (&$searchItem)use($request){
            if (!empty($request->query->get('buyer'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('buyer')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName = (isset($item->sender)&&property_exists($item->sender,'realName'))?$item->sender->realName:"";
            $item->createdDate = date("Y-m-d H:i:s", strtotime($item->created_at));
            if (time()>=strtotime($item->created_at)+24*3600){
                $item->expired = "是";
            }else{
                $item->expired = "否";
            }
            $item->getNum = UserRedPackets::where("sendUserId",$item->userId)->where("redpacketid",$item->id)->count("id")?:0;
        }]);
    }

}
