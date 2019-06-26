<?php

namespace App\Http\Controllers\Admin;

use App\Groups;
use App\ShipOrder;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipOrderController extends Controller
{
    //
    function index()
    {
        return view("admin.ship.index");
    }

    function orders(Request $request,ShipOrder $shipOrder)
    {
        return $this->models(...[$request,$shipOrder,function (&$searchItem)use($request){
            $searchItem['name']       = $request->name;
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("GroupId","=",$searchItem['name']);
            }

        },function (&$item){
            if ($item->sellerUserId==1){
                $item->sellerUserName = '平台';
            }else{
                $item->sellerUserName = property_exists($item->seller,'realName')?$item->seller->realName:$item->seller->name;
            }
            $item->typeName = ($item->type==1)?'商户':'平台';
            if ($item->userId){
                $item->userName = property_exists($item->buyer,'realName')?$item->buyer->realName:$item->buyer->name;;
                $item->statusName = "已售出";
                $item->createdDate = date("Y-m-d H", strtotime($item->CreateTime));
            }else{
                $item->userName = "";
                $item->statusName = "未卖出";
                $item->createdDate = "";
            }

        }]);
    }

    function remove(Groups $groups)
    {
        if($groups->delete()){
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }

}
