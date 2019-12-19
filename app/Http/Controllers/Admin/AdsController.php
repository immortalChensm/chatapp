<?php

namespace App\Http\Controllers\Admin;

use App\Ads;
use App\Http\Requests\Admin\StoreAdsPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    function index()
    {
        return view("admin.ads.index");
    }

    function edit()
    {
        if(isset(request()->id)){
            $ads = Ads::where("id","=",request()->id)->first();
        }
        $data = isset($ads)?$ads:'';
        return view("admin.ads.edit",compact('data'));
    }


    function ads(Request $request,Ads $ads)
    {
        return $this->models(...[$request,$ads,function (&$searchItem)use($request){
            $searchItem['name']   = $request->query->get('name');
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("name","LIKE","%".$searchItem['name']."%");
            }
        },function (&$item){

            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function store(StoreAdsPost $request)
    {
        if (isset($request->id)){
            return Ads::where("id","=",$request->id)->update(request()->except("_token,s"))?['code'=>1,'message'=>'更新成功']:['code'=>1,'message'=>'更新失败'];
        }else{
           return Ads::create(request()->except("_token,s"))?['code'=>1,'message'=>'添加成功']:['code'=>1,'message'=>'添加失败'];
        }
    }

    /**
     * 删除照片
     */
    function removePhotoFile()
    {
        if (Images::where("uriKey","=",request()->fileKeyName)->delete()){
            if ($this->removeCosFile(['key'=>request()->fileKeyName])['code']==1){
                return response()->json(['code'=>1,'message'=>'移除成功']);
            }
        }
    }

    function remove(Photos $photos)
    {
        //不是自己的相册禁止操作
        $photos->id = $photos->photoId;
        if (($checkIfCan = $this->isManager($photos))&&$checkIfCan['code']==0){
            return $checkIfCan;
        }
        //删除数据库的记录+删除存储桶上的文件+清空缓存
        $cosKeyNames = Images::where("photoId","=",$photos->photoId)->get();
        if ($photos->delete()){
            $cacheKey = config("cos")['cachePhotoKey'].$photos->photoId;
            $this->getRedisClient()->del($cacheKey);
            foreach($cosKeyNames as $item){
                $this->removeCosFile(['key'=>$item->uriKey]);
            }
            Images::where("photoId",$photos->photoId)->delete();
            return ['code'=>1,'message'=>'删除成功！'];
        }
    }

}
