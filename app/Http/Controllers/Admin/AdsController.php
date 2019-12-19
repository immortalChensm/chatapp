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
        if (!empty($data)){
            $data['uri'] = explode(",",$data['uri']);
        }
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

            $item->createdDate = date("Y-m-d H", ($item->created_at));
        }]);
    }

    function store(StoreAdsPost $request)
    {
        $data = request()->except("_token","s");
        $data['uri'] = implode(",",$data['uri']);
        $data['created_at'] = time();
        if (isset($request->id)){
            return Ads::where("id","=",$request->id)->update($data)?['code'=>1,'message'=>'更新成功']:['code'=>1,'message'=>'更新失败'];
        }else{
           return Ads::create($data)?['code'=>1,'message'=>'添加成功']:['code'=>1,'message'=>'添加失败'];
        }
    }

    /**
     * 删除
     */
    function removeAdsFile()
    {
        if (Images::where("uriKey","=",request()->fileKeyName)->delete()){
            if ($this->removeCosFile(['key'=>request()->fileKeyName])['code']==1){
                return response()->json(['code'=>1,'message'=>'移除成功']);
            }
        }
    }

    function remove(Ads $ads)
    {
        return $ads->delete()?['code'=>1,'message'=>'删除成功！']:['code'=>0,'message'=>'删除失败！'];
    }

}
