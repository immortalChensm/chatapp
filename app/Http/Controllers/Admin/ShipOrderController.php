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
            $item->userName = (isset($item->buyer->name)?$item->buyer->name:$item->buyer->realName);
            $item->sellerUserName = (isset($item->seller->name)?$item->seller->name:$item->seller->realName);
            $item->typeName = ($item->type==1)?'商户':'平台';
            if ($item->userId){
                $item->statusName = "已售出";
            }else{
                $item->statusName = "未卖出";
            }
            $item->createdDate = date("Y-m-d H", $item->CreateTime);
        }]);
    }

    function remove(Groups $groups)
    {
        if($groups->delete()){
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }

}
