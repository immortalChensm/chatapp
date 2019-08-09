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
        $data['userNum'] = DB::table("users")->count("userId");
        $data['articleNum'] = DB::table("articles")->count("articleId")+DB::table("videos")->count("videoId")+DB::table("musics")->count("musicId")+DB::table("photos")->count("photoId");
        $data['shipSale'] = DB::table("users_ships_order")->where("userId","=",1)->where("type","=",2)->sum("payMoney");
        $data['spaceSale'] = DB::table("users_space_order")->sum("shipNum");
        $data['users'] = DB::table("users")->select(["name","created_at","headImgUrl"])->orderBy("created_at","desc")->limit(8)->get();

        foreach ($data['users'] as $k=>$user){
            empty($user->headImgUrl)&&$user->headImgUrl='other/defaultlogo.png';
            $data['users'][$k]->headImgUrl = downloadCosFile(['fileKeyName'=>$user->headImgUrl,'expire'=>config("cos.expire")]);
        }
        $data['shipOrder'] = DB::table("users_ships_order")->orderBy("created_at","desc")->limit(10)->get();
        if (!empty($data['shipOrder'])){
            foreach ($data['shipOrder'] as $k=>$item){
                if (!empty($item->userId)){
                    $data['shipOrder'][$k]->userInfo = DB::table("users")->where("userId",$item->userId)->value("name");
                }
                if ($item->sellerUserId!=1){
                    $data['shipOrder'][$k]->sellerUser = DB::table("users")->where("userId",$item->sellerUserId)->value("name");
                }
            }
        }

        return view("admin.home.index",compact('data'));
    }

    function test()
    {
        return "hello,world";
    }
}
