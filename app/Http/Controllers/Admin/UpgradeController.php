<?php

namespace App\Http\Controllers\Admin;
use App\Upgrade;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpgradeController extends Controller
{

    function index()
    {
        return view("admin.upgrade.index");
    }
    function upgrade(Request $request,Upgrade $upgrade)
    {
        return $this->models(...[$request,$upgrade,function (&$searchItem)use($request){
            if (!empty($request->query->get('name'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('name')."%")->pluck("userId");
                $searchItem['userId']   = count($userIds->toArray())>0?$userIds->toArray():'';
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])&&!empty($searchItem['userId'])){
                $query->whereIn("userId",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName        = User::where("userId", $item['userId'])->value("name");
            $item->storageSize     = $item->storageSize."M";
            $item->createdDate     = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function remove(Upgrade $upgrade)
    {
        return $this->removeModel($upgrade,1);
    }
}
