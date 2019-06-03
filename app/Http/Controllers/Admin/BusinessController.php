<?php

namespace App\Http\Controllers\Admin;

use App\Business;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{

    function index()
    {
        return view("admin.business.index");
    }
    function business(Request $request,Business $business)
    {
        return $this->models(...[$request,$business,function (&$searchItem)use($request){
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
            $item->type            = (function($type){$typeName=['1'=>'撰写专户','2'=>'专业拍摄','3'=>'音乐制作','4'=>'视频拍摄'];return $typeName[$type];})($item->type);
            $item->createdDate     = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function remove(Business $business)
    {
        return $this->removeModel($business,1);
    }
}
