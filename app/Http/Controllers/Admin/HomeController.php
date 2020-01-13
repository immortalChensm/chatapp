<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        set_error_handler(function(){});
        $data['userNum']    = DB::table("users")->count("userId");
        $data['articleNum'] = DB::table("articles")->count("articleId") + DB::table("videos")->count("videoId") + DB::table("musics")->count("musicId") + DB::table("photos")->count("photoId");
        $data['shipSale']   = DB::table("users_ships_order")->where("sellerUserId", "=", 1)->where("type", "=", 2)->sum("payMoney");
        $data['spaceSale']  = DB::table("users_space_order")->sum("shipNum");
        $data['users']      = DB::table("users")->select(["name as realName", "created_at","headImgUrl"])->orderBy("created_at","desc")->limit(8)->get();
        $businessTotal      = DB::table("users_business")->select(["id", "state"])->count("id");
        $businessOk      = DB::table("users_business")->where("state","=",1)->select(["id", "state"])->count("id");
        if ($businessOk&&$businessTotal){
            $data['business'] = round(($businessOk/$businessTotal)*100,1);
        }else{
            $data['business'] = 0;
        }

        foreach ($data['users'] as $k=>$user){
            empty($user->headImgUrl)&&$user->headImgUrl='http://148.70.221.198/chuanlian.com/f6c30a1a27804e4f83e5b44c4b4dc020_1578896426279.png';
//            $data['users'][$k]->headImgUrl = downloadCosFile(['fileKeyName'=>$user->headImgUrl,'expire'=>config("cos.expire")]);
            $data['users'][$k]->headImgUr = $user->headImgUrl;
        }
        $data['shipOrder'] = DB::table("users_ships_order")->orderBy("created_at","desc")->limit(10)->get();
        if (!empty($data['shipOrder'])){
            foreach ($data['shipOrder'] as $k=>$item){
                if (!empty($item->userId)){
                    $data['shipOrder'][$k]->userInfo = DB::table("users")->where("userId","=",$item->userId)->value("realName");
                }else{
                    $data['shipOrder'][$k]->userInfo = '';
                }
                if ($item->sellerUserId!=1){
                    $data['shipOrder'][$k]->sellerUser = DB::table("users")->where("userId","=",$item->sellerUserId)->value("realName");
                }else{
                    $data['shipOrder'][$k]->sellerUser = '';
                }
            }
        }
        restore_error_handler();
        return view("admin.home.index",compact('data'));
    }

    function test()
    {
        return "hello,world";
    }
}
