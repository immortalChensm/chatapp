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
        return view("admin.home.index",compact('data'));
    }

    function test()
    {
        return "hello,world";
    }
}
