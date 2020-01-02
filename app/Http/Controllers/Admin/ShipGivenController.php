<?php

namespace App\Http\Controllers\Admin;

use App\ShipGiven;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipGivenController extends Controller
{
    //
    function index()
    {
        return view("admin.ship.given");
    }

    function orders(Request $request,ShipGiven $shipGiven)
    {
        return $this->models(...[$request,$shipGiven,function (&$searchItem)use($request){

            if (!empty($request->query->get('sender'))){
                $userIds = User::where("realName","LIKE","%".$request->query->get('sender')."%")->value("userId");
                $searchItem['givenUserId']   = $userIds;
            }
            if (!empty($request->query->get('giver'))){
                $userIds = User::where("realName","LIKE","%".$request->query->get('giver')."%")->value("userId");
                $searchItem['userId']   = $userIds;
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])){
                $query->where("userId","=",$searchItem['userId']);
            }
            if (isset($searchItem['givenUserId'])){
                $query->where("givenUserId","=",$searchItem['givenUserId']);
            }

        },function (&$item){
            $item->userName = (isset($item->user)&&property_exists($item->user,'realName'))?$item->user->realName:"";
            $item->givenUserName = (isset($item->giver)&&property_exists($item->giver,'realName'))?$item->giver->realName:"";
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

}
