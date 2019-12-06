<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\QrCode;
class SystemController extends Controller
{
    //
    function index()
    {
        $data = (new Collection(Db::table("system")->get()))->toArray();
        return view("admin.system.index",compact('data'));
    }

    /***********************app*********************/
    function app()
    {
        return view("admin.system.app");
    }
    function appList(Request $request,App $app)
    {
        return $this->models(...[$request,$app,function (&$searchItem)use($request){
            $searchItem['version']   = $request->query->get('version');
        },function ($query,&$searchItem){
            if ($searchItem['version']){
                $query->where("version","LIKE","%".$searchItem['version']."%");
            }

        },function (&$item){
            $item->createdDate = date("Y-m-d H", $item->created_at);
            $qrCode = new QrCode($item->uri);
            $file = substr($item->file,0,-4)."1.png";
            $qrCode->writeFile($file);
            $img = substr($item->uri,0,-4)."1.png";
            $item->uri = "<div class='qrcode'><img class='minImg' src='$img' width='50px' height='50px'/></div><div  class='sourceImg' style='display: none'><img src='$img'/> </div>";
        }]);
    }
    function appEdit()
    {
        isset(request()->id)?$data=App::where("id","=",request()->id)->first():$data='';
        return view("admin.system.app_edit",compact('data'));
    }
    function appStore(Request $request)
    {
        if (isset($request->name)&&isset($request->platform)&&isset($request->version)&&isset($request->uri)) {
            $prepareData = ['name'        => $request->name,
                            'description' => $request->description,
                            'version'     => $request->version,
                            'uri'         => $request->uri,
                            'file'         => $request->file,
                            'platform'    => $request->platform];


            if (isset($request->id)) {
                $result = App::where("id", "=", $request->id)->update($prepareData) ? ['code' => 1, 'message' => '更新成功'] : ['code' => 0, 'message' => '更新失败'];
                return $result;
            } else {
                return App::create(array_merge($prepareData, [
                    'created_at' => time()
                ])) ? ['code' => 1, 'message' => '添加成功'] : ['code' => 0, 'message' => '添加失败'];
            }
        }else{
            return ['code' => 0, 'message' => '参数错误'];
        }
    }
    function removeApp(App $app)
    {
        $uriKey = $app->file;
        if ($app->delete()){
            unlink($uriKey);
            return ['code'=>1,'message'=>'删除成功！'];
        }
    }

    /***********************app*********************/


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
        if (!empty($data)){
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
        }else{
            $data = [];
        }

        return view("admin.system.top",compact('data'));
    }
}
