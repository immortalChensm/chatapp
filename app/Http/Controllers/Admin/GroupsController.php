<?php

namespace App\Http\Controllers\Admin;

use App\Groups;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
    //
    function index()
    {
        return view("admin.groups.index");
    }

    function groups(Request $request,Groups $groups)
    {
        return $this->models(...[$request,$groups,function (&$searchItem)use($request){
            $searchItem['name']       = $request->name;
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("GroupId","=",$searchItem['name']);
            }

        },function (&$item){
            $item->Owner_Name = $item->user->name;
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function remove(Groups $groups)
    {
        if($groups->delete()){
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }

}