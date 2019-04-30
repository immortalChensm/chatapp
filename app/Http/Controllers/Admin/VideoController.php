<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoPost;
use App\Videos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    function index()
    {
        return view("admin.video.index");
    }

    function edit()
    {
        if(isset(request()->videoId)){
            $model = Videos::where("videoId","=",request()->videoId)->first();
            $cacheKey = config("cos")['cacheVideoKey'].$model->videoId;
            if ($this->getRedisClient()->exists($cacheKey)){
                $uri = $this->getRedisClient()->get($cacheKey);
            }else{
                $uri = $this->downloadCosFile([
                    'fileKeyName'=>$model['uriKey'],
                    'expire'=>config('cos')['expire']
                ])['data'];
                $this->getRedisClient()->set($cacheKey,$uri,config('cos')['cacheTime']);
            }
            $model['uri'] = $uri;

        }
        $data = isset($model)?$model:'';
        return view("admin.video.edit",compact('data'));
    }

    function videos(Request $request,Videos $video)
    {
        return $this->models(...[$request,$video,function (&$searchItem)use($request){
            $searchItem['title']   = $request->query->get('title');
        },function ($query,&$searchItem){
            if ($searchItem['title']){
                $query->where("title","LIKE","%".$searchItem['title']."%");
            }
        },function (&$item){
            $item->isShow      = $item->isShow == 0 ? '是' : '否';
            $item->canShared   = $item->canShared == 1 ? '是' : '否';
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }


    function store(StoreVideoPost $request)
    {
        $prepareData = [ 'title'        => $request->title,
                         'introduction' => $request->introduction,
                         'uriKey'       => $request->uriKey,
                         'cover'=>$request->uriKey
                         ];
        if (isset($request->videoId)){
            $model=Videos::where("videoId","=",$request->videoId)->first();
            $model->id = $model->videoId;
            if (($checkCan = $this->isManager($model))&&$checkCan['code']==0){
                return $checkCan;
            }
            //如果是修改自己的
            $cacheKey = config("cos")['cacheVideoKey'].$model->musicId;
            $result = Videos::where("videoId","=",$request->videoId)->update($prepareData)?['code' => 1, 'message' => '更新成功'] : ['code' => 0, 'message' => '更新失败'];
            if ($result['code']==1){
                $this->getRedisClient()->set($cacheKey,$this->downloadCosFile([
                    'fileKeyName'=>$prepareData['uriKey'],
                    'expire'=>config('cos')['expire']
                ])['data'],config('cos')['cacheTime']);
            }
            return $result;

        }else {
            return Videos::create(array_merge($prepareData,[
                'userId'       => 1,
                'userType'     => 2
            ])) ? ['code' => 1, 'message' => '添加成功'] : ['code' => 0, 'message' => '添加失败'];
        }
    }

    function remove(Videos $videos)
    {
        $videos->id = $videos->videoId;
        if (($checkIfCan = $this->isManager($videos))&&$checkIfCan['code']==0){
            return $checkIfCan;
        }
        //删除数据库的记录+删除存储桶上的文件+清空缓存
        $uriKey = $videos->uriKey;
        if ($videos->delete()){
            $cacheKey = config("cos")['cacheMusicKey'].$videos->videoId;
            $this->getRedisClient()->del($cacheKey);
            $this->removeCosFile(['key'=>$uriKey]);
            return ['code'=>1,'message'=>'删除成功！'];
        }
    }

    //屏蔽或限制分享
    function shieldOrShare(Videos $videos)
    {
        return $this->modelShieldOrShare($videos);
    }

    function play(Videos $videos)
    {
        return $this->playModel($videos);
    }
}
