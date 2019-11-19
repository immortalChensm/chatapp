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
            if ($item->payType==3){
                $item->payType = '支付宝';
            }else if ($item->payType==2){
                $item->payType = '微信';
            }else{
                $item->payType ='账户余额';
            }

            if (isset($item->buyer)){
                $item->userName = property_exists($item->buyer,'realName')?$item->buyer->realName:$item->buyer->name;
            }else{
                $item->userName = "暂无";
            }

            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
            if ($item->userId&&$item->state==1){
                //$item->userName = property_exists($item->buyer,'realName')?$item->buyer->realName:$item->buyer->name;
                $item->statusName = "已支付";
                $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
            }else{
                //$item->userName = "";
                $item->statusName = "未支付";

            }
            //有买家购买
            if (!empty($item->userId)){
                $item->shipNum = $item->shipNum."/".$item->shipNum;
                $item->payMoney =  $item->payMoney."/".$item->payMoney;

                if ($item->sellerUserId==1){
                    $item->createdDate =  date("Y-m-d H", strtotime($item->created_at))."/".date("Y-m-d H", strtotime($item->created_at));
                }else{
                    $item->createdDate =  date("Y-m-d H", strtotime($item->created_at))."/".date("Y-m-d H", strtotime($item->updated_at));
                }

                if ($item->state==1){
                    $item->statusName = "已支付/已售出";
                }else{
                    $item->statusName = "待支付/已售出";
                }

            }else{
                $item->shipNum = "0/".$item->shipNum;
                $item->payMoney =  "0/".$item->payMoney;
                $item->createdDate =  "0/".date("Y-m-d H", strtotime($item->updated_at));
                $item->statusName = "未购买/出售中";
            }

        }]);
    }

}
