<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //
    function index()
    {
        return view("admin.users.index");
    }

    function users(Request $request,User $user)
    {
        return $this->models(...[$request,$user,function (&$searchItem)use($request){
            $searchItem['name']       = $request->name;
            $searchItem['mobile']     = $request->mobile;
            $searchItem['handNum']    = $request->handNum;
            $searchItem['realName']   = $request->realName;
            $searchItem['sex']        = $request->sex;
            $searchItem['isValiated'] = $request->isValiated;
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("name","LIKE","%".$searchItem['name']."%");
            }
            if ($searchItem['mobile']){
                $query->where("mobile","LIKE","%".$searchItem['mobile']."%");
            }
            if ($searchItem['handNum']){
                $query->where("handNum","LIKE","%".$searchItem['handNum']."%");
            }
            if ($searchItem['realName']){
                $query->where("realName","LIKE","%".$searchItem['realName']."%");
            }
            if ($searchItem['sex']){
                $query->where("sex","=",$searchItem['sex']);
            }
            if ($searchItem['isValiated']){
                $query->where("isValiated","=",$searchItem['isValiated']);
            }

        },function (&$item){
            $item->sex         = $item->sex == 1 ? '男' : '女';
            $item->isValiated  = $item->isValiated == 1 ? '已认证' : '未认证';
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function remove(User $user)
    {
        if($user->delete()){
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }
}