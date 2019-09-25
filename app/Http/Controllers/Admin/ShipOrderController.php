<?php

namespace App\Http\Controllers\Admin;

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
            $searchItem['type']       = $request->type;
            if (!empty($request->query->get('seller'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('seller')."%")->value("userId");
                $searchItem['sellerUserId']   = $userIds;
            }
            if (!empty($request->query->get('buyer'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('buyer')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['type'])){
                $query->where("type","=",$searchItem['type']);
            }
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
            if (isset($searchItem['sellerUserId'])){
                $query->where("sellerUserId","=",$searchItem['sellerUserId']);
            }

        },function (&$item){
            if ($item->sellerUserId==1){
                $item->sellerUserName = '平台';
            }else{
                $item->sellerUserName = property_exists($item->seller,'realName')?$item->seller->realName:$item->seller->name;
            }
            $item->typeName = ($item->type==1)?'商户':'平台';
            $item->payType = ($item->payType==1)?'账号余额':($item->payType==2)?'微信':'支付宝';

            $item->userName = property_exists($item->buyer,'realName')?$item->buyer->realName:$item->buyer->name;
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
            if ($item->userId&&$item->state==1){
                //$item->userName = property_exists($item->buyer,'realName')?$item->buyer->realName:$item->buyer->name;
                $item->statusName = "已支付";
                $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
            }else{
                //$item->userName = "";
                $item->statusName = "未支付";

            }

        }]);
    }

}
