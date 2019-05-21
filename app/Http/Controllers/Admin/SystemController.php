<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    //
    function index()
    {
        $data = (new Collection(Db::table("system")->get()))->toArray();
        return view("admin.system.index",compact('data'));
    }

    function store()
    {
        $data = request()->except("_token","s");
        foreach($data['config'] as $field=>$value){
            DB::table("system")->where("name","=",$field)->update(['value'=>$value]);
        }
        return ['code'=>1,'message'=>'保存成功'];
    }

    function top()
    {
        $data = DB::table("top")->first();
        if ($data->topType==1){
            $data->title = DB::table("articles")->where("articleId",$data->topId)->value("title");
            $data->name = "文章";
        }
        if ($data->topType==2){
            $data->title = DB::table("photos")->where("photoId",$data->topId)->value("title");
            $data->name = "图片";
        }
        if ($data->topType==3){
            $data->title = DB::table("musics")->where("musicId",$data->topId)->value("title");
            $data->name = "音乐";
        }
        if ($data->topType==4){
            $data->title = DB::table("videos")->where("videoId",$data->topId)->value("title");
            $data->name = "视频";
        }
        return view("admin.system.top",compact('data'));
    }
}
