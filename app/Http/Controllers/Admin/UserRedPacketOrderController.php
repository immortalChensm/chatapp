<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserRedPackets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRedPacketOrderController extends Controller
{
    //
    function index()
    {
        return view("admin.redpacket.income");
    }

    function orders(Request $request,UserRedPackets $redPackets)
    {
        return $this->models(...[$request,$redPackets,function (&$searchItem)use($request){
            if (!empty($request->query->get('sender'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('sender')."%")->value("userId");
                $searchItem['sendUserId']   = $userIds;
            }
            if (!empty($request->query->get('recver'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('recver')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['sendUserId'])){
                $query->where("sendUserId","=",$searchItem['sendUserId']);
            }
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName = property_exists($item->sender,'realName')?$item->sender->realName:$item->sender->name;
            $item->recvName = property_exists($item->recver,'realName')?$item->recver->realName:$item->recver->name;
            $item->recvDate = date("Y-m-d H:i:s", strtotime($item->created_at));
            $item->createdDate = date("Y-m-d H:i:s", strtotime($item->sendDate->created_at));
        }]);
    }

}
