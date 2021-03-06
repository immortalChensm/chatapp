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
                $userIds = User::where("realName","LIKE","%".$request->query->get('name')."%")->pluck("userId");
                $searchItem['userId']   = count($userIds->toArray())>0?$userIds->toArray():'';
            }
            $searchItem['type'] = $request->query->get('type');
        },function ($query,&$searchItem){

            if (isset($searchItem['userId'])&&!empty($searchItem['userId'])){
                $query->whereIn("userId",$searchItem['userId']);
            }
            if (isset($searchItem['type'])&&!empty($searchItem['type'])){
                $query->where("type",$searchItem['type']);
            }
        },function (&$item){
           if ($item->state==0){
               $item->state = "待处理";
           }else if($item->state==1){
               $item->state = "已排班";
           }else{
               $item->state = "已结账";
           }
            $item->userName        = User::where("userId", $item['userId'])->value("realName")?User::where("userId", $item['userId'])->value("realName"):User::where("userId", $item['userId'])->value("name");
            $item->type            = (function($type){$typeName=['1'=>'撰写专记','2'=>'专业拍摄','3'=>'音乐制作','4'=>'视频拍摄'];return $typeName[$type];})($item->type);
            $item->createdDate     = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function remove(Business $business)
    {
        return $this->removeModel($business,1);
    }

    function state(Business $business)
    {
        return $business->update(['state'=>request('type')])?['code'=>1,'message'=>'操作成功']:['code'=>0,'message'=>'操作失败'];
    }

    function mark(Business $business)
    {
        $business->update(['mark'=>request("mark")]);
        return ['code'=>1,'message'=>'操作成功'];
    }
}
