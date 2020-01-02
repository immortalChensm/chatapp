<?php

namespace App\Http\Controllers\Admin;

use App\Recharge;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeOrderController extends Controller
{
    //
    function index()
    {
        return view("admin.recharge.index");
    }

    function orders(Request $request,Recharge $recharge)
    {
        return $this->models(...[$request,$recharge,function (&$searchItem)use($request){
            if (!empty($request->query->get('name'))){
                $userIds = User::where("realName","LIKE","%".$request->query->get('name')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName = (isset($item->sender)&&property_exists($item->sender,'realName'))?$item->sender->realName:"";
            $item->createdDate = date("Y-m-d H:i:s", strtotime($item->created_at));
            $item->payType = $item->payType==1?'微信':'支付宝';
            if ($item->state==1){
                $item->state = "已付款";
            }else {
                $item->state = "未付款";
            }
        }]);
    }

}
