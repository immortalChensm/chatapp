<?php

namespace App\Http\Controllers\Admin;

use App\Transfer;
use App\User;
use App\UserRedPackets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferOrderController extends Controller
{
    //
    function index()
    {
        return view("admin.transfer.index");
    }

    function orders(Request $request,Transfer $transfer)
    {
        return $this->models(...[$request,$transfer,function (&$searchItem)use($request){
            if (!empty($request->query->get('buyer'))){
                $userIds = User::where("realName","LIKE","%".$request->query->get('buyer')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName = property_exists($item->sender,'realName')?$item->sender->realName:$item->sender->name;
            $item->whoName = property_exists($item->who,'realName')?$item->who->realName:$item->who->name;
            $item->createdDate = date("Y-m-d H:i:s", strtotime($item->created_at));
            if ($item->state==1){
                $item->state = "未领取";
            }else if ($item->state==2){
                $item->state = "已收款";
            }else if ($item->state==3){
                $item->state = "已过期";
            }
        }]);
    }

}
