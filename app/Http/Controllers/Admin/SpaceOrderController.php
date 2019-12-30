<?php

namespace App\Http\Controllers\Admin;

use App\SpaceOrder;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpaceOrderController extends Controller
{
    //
    function index()
    {
        return view("admin.space.index");
    }

    function orders(Request $request,SpaceOrder $spaceOrder)
    {
        return $this->models(...[$request,$spaceOrder,function (&$searchItem)use($request){
            if (!empty($request->query->get('buyer'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('buyer')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
        },function (&$item){

            $item->userName = (isset($item->buyer)&&property_exists($item->buyer,'realName'))?$item->buyer->realName:"";
            $item->spaceNum = $item->storageSize/1024;
            $item->sellerUserName = "平台";
            $item->buyDate = date("Y-m-d H:i:s", $item->buyTime);
            $item->expireDate = date("Y-m-d", $item->expireTime);
        }]);
    }

}
