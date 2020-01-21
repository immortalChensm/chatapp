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

    function users(Request $request, User $user)
    {
        return $this->models(...[$request, $user, function (&$searchItem) use ($request) {
            $searchItem['name']       = $request->name;
            $searchItem['mobile']     = $request->mobile;
            $searchItem['handNum']    = $request->handNum;
            $searchItem['realName']   = $request->realName;
            $searchItem['sex']        = $request->sex;
            $searchItem['isValiated'] = $request->isValiated;
        }, function ($query, &$searchItem) {
            if ($searchItem['name']) {
                $query->where("name", "LIKE", "%" . $searchItem['name'] . "%");
            }
            if ($searchItem['mobile']) {
                $query->where("mobile", "LIKE", "%" . $searchItem['mobile'] . "%");
            }
            if ($searchItem['handNum']) {
                if (strlen($searchItem['handNum'])>6){
                    $area = substr($searchItem['handNum'],0,6);
                    $handNum = substr($searchItem['handNum'],6);
                    $query->where("handNum", "LIKE", "%" . $handNum . "%")->where("area","=",$area);
                }else{
                    $query->where("area", "LIKE", "%" . $searchItem['handNum'] . "%");
                }

            }
            if ($searchItem['realName']) {
                $query->where("realName", "LIKE", "%" . $searchItem['realName'] . "%");
            }
            if ($searchItem['sex']) {
                $query->where("sex", "=", $searchItem['sex']);
            }
            if (isset($searchItem['isValiated'])) {
                $query->where("isValiated", "=", $searchItem['isValiated']);
            }

        }, function (&$item) {
            $item->sex         = $item->sex == 1 ? '男' : '女';
            $item->isValiated  = $item->isValiated == 1 ? '已认证' : '未认证';
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
//            $imFriends = session("imFriends");
//            if (in_array($item->userId,$imFriends)){
//                $item->chatBtn = 1;
//            }else{
//                $item->chatBtn = 0;
//            }
            $item->password = 0;
            $item->payPassword = 0;
            $item->idCard = 0;
            $item->idCardFrontPic = 0;
            $item->idCardBackPic = 0;
            $item->handNum = $item->area.$item->handNum;
            $item->status = ($item->status==1)?'正常':'已注销';
        }]);
    }

    function remove(User $user)
    {
        $userId = $user->userId;
        if ($user->delete()) {
            $this->getApi("POST","api/account/delete",[
                'userId'=>$userId
            ]);

            return ['code' => 1, 'message' => '删除成功'];
        } else {
            return ['code' => 0, 'message' => '删除失败'];
        }
    }

    function edit()
    {
        isset(request()->userId) ? $data = User::where("userId", "=", request()->userId)->first() : $data = '';
//        !empty($data['headImgUrl']) ? $headImgUrl = $data['headImgUrl'] : $headImgUrl = 'other/defaultlogo.png';
//        $result = $this->downloadCosFile([
//            'fileKeyName' => $headImgUrl,
//            'expire'      => config('cos')['expire']
//        ]);
//        if ($result['code'] == 1) {
//            $data['headImgUrl'] = $result['data'];
//        }
        $this->userProfileHandler($data);
        return view("admin.users.edit", compact('data'));
    }

    function setting()
    {
       DB::table("users_extend")->where("userId",request("userId"))->update([request("field")=>request("value")]);
       $msgTitle = [
           'canLogin'=>(request("value")==1?"经综合评估，已解除你登录传联的限制！":"接到举报，你涉嫌利用传联从事违规活动，已被系统禁止登录！"),
           'canPost'=>(request("value")==1?"经综合评估，已解除你发布文章的限制！":"系统检测到你发布的文章多次违规，已被限制发布！"),
           'canPhoto'=>(request("value")==1?"经综合评估，已解除你发布相册的限制！":"系统检测到你发布的相册多次违规，已被限制发布！"),
           'canMusic'=>(request("value")==1?"经综合评估，已解除你发布音频的限制！":"系统检测到你发布的音频多次违规，已被限制发布！"),
           'canVideo'=>(request("value")==1?"经综合评估，已解除你发布视频的限制!":"系统检测到你发布的视频多次违规，已被限制发布！"),
           'canComment'=>(request("value")==1?"经综合评估，已解除你评论的限制！":"系统检测到你的评论多次违规，已被限制评论！"),
           'canShare'=>(request("value")==1?"经综合评估，已解除你分享的限制！":"系统检测到你分享的内容多次违规，已被限制分享！"),
       ];
       if (in_array(request("field"),array_keys($msgTitle))){
           $this->getApi("POST","api/im/sendMsg",[
               'content'=>$msgTitle[request("field")],
               'userId'=>request("userId"),
               'msgType'=>6,
               'title'=>"系统警告",
           ]);
           if (request("field")=='canLogin'){
               $mobile   = DB::table("users")->where("userId", request("userId"))->value("mobile");
               $content = (request("value")==1?"经综合评估，已解除你登录传联的限制！":"接到举报，你涉嫌利用传联从事违规活动，已被系统禁止登录！");
               $this->getApi("POST","api/verify/code",[
                   'message'=>$content,
                   'mobile'=>$mobile,
                   'scene'=>3
               ]);
           }
       }

       return ['code' => 1, 'message' => '设置成功'];
    }

    function userProfileHandler(&$data)
    {
        $data['subscribeNum']   = DB::table("subscribes")->where("userId", $data['userId'])->where("followerId","<>",0)->count("followerId");
        $data['followerNum']    = DB::table("subscribes")->where("followerId", $data['userId'])->count("userId");
        $data['totalPraiseNum'] = DB::table("user_praises")->whereIn("userId", [$data['userId']])->sum("praiseNum");
        $data['sentMoney']      = DB::table("redpacket")->whereIn("userId", [$data['userId']])->sum("money");
        $data['recvMoney']      = DB::table("users_redpacket")->whereIn("userId", [$data['userId']])->sum("money");
        $data['refundMoney']    = DB::table("users_refund_redpackets")->whereIn("userId", [$data['userId']])->sum("money");
        $data['loginInfo']      = DB::table("users_extend")->where("userId", $data['userId'])->first();
        $data['relationNum']      = DB::table("user_relation")->whereIn("userId", [$data['userId']])->count("userId");
        empty($data['headImgUrl'])&&$data['headImgUrl']='http://148.70.221.198/pc/image/cl_user_avatar.png';
        if ($data['isValiated'] == 1) {
//            $result = $this->downloadCosFile([
//                'fileKeyName' => $data['idCardFrontPic'],
//                'expire'      => config('cos')['expire']
//            ]);
//            if ($result['code'] == 1) {
//                $data['idCardFace'] = $result['data'];
//            }
//            $result = $this->downloadCosFile([
//                'fileKeyName' => $data['idCardBackPic'],
//                'expire'      => config('cos')['expire']
//            ]);
//            if ($result['code'] == 1) {
//                $data['idCardWall'] = $result['data'];
//            }
        }


    }
}
