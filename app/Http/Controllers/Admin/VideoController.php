<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoPost;
use App\Videos;
use App\Http\Controllers\Controller;

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

    function store(StoreVideoPost $request)
    {
        $prepareData = [ 'title'        => $request->title,
                         'introduction' => $request->introduction,
                         'uriKey'       => $request->uriKey,
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
}
