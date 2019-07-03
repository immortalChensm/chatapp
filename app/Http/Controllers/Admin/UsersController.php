<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

    function edit()
    {
        isset(request()->userId)?$data=User::where("userId","=",request()->userId)->first():$data='';
        !empty($data['headImgUrl'])?$headImgUrl = $data['headImgUrl']:$headImgUrl='defaultlogo.png';
        $result = $this->downloadCosFile([
            'fileKeyName'=>$headImgUrl,
            'expire'=>config('cos')['expire']
        ]);
        if ($result['code']==1){
            $data['headImgUrl'] = $result['data'];
        }
        $this->userProfileHandler($data);
        return view("admin.users.edit",compact('data'));
    }

    function userProfileHandler(&$data)
    {
        $data['subscribeNum']   = DB::table("subscribes")->where("userId", $data['userId'])->count("followerId");
        $data['followerNum']    = DB::table("subscribes")->where("followerId", $data['userId'])->count("userId");
        $data['totalPraiseNum']    = DB::table("user_praises")->whereIn("userId", [$data['userId']])->sum("praiseNum");
        $data['sentMoney']    = DB::table("redpacket")->whereIn("userId", [$data['userId']])->sum("money");
        $data['recvMoney']    = DB::table("users_redpacket")->whereIn("userId", [$data['userId']])->sum("money");
        $data['refundMoney']    = DB::table("users_refund_redpackets")->whereIn("userId", [$data['userId']])->sum("money");
        $data['loginInfo'] = DB::table("users_extend")->where("userId", $data['userId'])->first();
    }
}
