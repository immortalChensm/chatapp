<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreMusicPost;
use App\Musics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MusicsController extends Controller
{
    /**
     * 音乐列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        return view("admin.musics.index");
    }

    function musics(Request $request,Musics $musics)
    {
        return $this->models(...[$request,$musics,function (&$searchItem)use($request){
            $searchItem['title']   = $request->query->get('title');
            $searchItem['singer']   = $request->query->get('singer');
        },function ($query,&$searchItem){
            if ($searchItem['title']){
                $query->where("title","LIKE","%".$searchItem['title']."%");
            }
            if ($searchItem['singer']){
                $query->where("singer","LIKE","%".$searchItem['singer']."%");
            }
        },function (&$item){
            if ($item->userType==2){
                $item->userId      = "平台发布";
            }else{
                $item->userId      = User::where("userId","=",$item['userId'])->value("name");
            }
            $item->isShow      = $item->isShow == 0 ? '是' : '否';
            $item->canShared  = $item->canShared == 1 ? '是' : '否';
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function edit()
    {
        if(isset(request()->musicId)){
            $model = Musics::where("musicId","=",request()->musicId)->first();
            $cacheKey = config("cos")['cacheMusicKey'].$model->musicId;
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
        return view("admin.musics.edit",compact('data'));
    }

    function store(StoreMusicPost $request)
    {
        $prepareData = [ 'title'        => $request->title,
                         'introduction' => $request->introduction,
                         'uriKey'       => $request->uriKey,
                         'singer'       => $request->singer];
        if (isset($request->musicId)){
            $model=Musics::where("musicId","=",$request->musicId)->first();
            $model->id = $model->musicId;
            if (($checkCan = $this->isManager($model))&&$checkCan['code']==0){
                return $checkCan;
            }
            //如果是修改自己的
            $cacheKey = config("cos")['cacheMusicKey'].$model->musicId;
            $result = Musics::where("musicId","=",$request->musicId)->update($prepareData)?['code' => 1, 'message' => '更新成功'] : ['code' => 0, 'message' => '更新失败'];
            if ($result['code']==1){
                $this->getRedisClient()->set($cacheKey,$this->downloadCosFile([
                    'fileKeyName'=>$prepareData['uriKey'],
                    'expire'=>config('cos')['expire']
                ])['data'],config('cos')['cacheTime']);
            }
            return $result;

        }else {
            return Musics::create(array_merge($prepareData,[
                'userId'       => 1,
                'userType'     => 2
            ])) ? ['code' => 1, 'message' => '添加成功'] : ['code' => 0, 'message' => '添加失败'];
        }
    }

    function removeMusicFile()
    {
        if ($this->removeCosFile(['key'=>request()->fileKeyName])['code']==1){
            return response()->json(['code'=>1,'message'=>'移除成功']);
        }

    }

    function remove(Musics $musics)
    {
        $musics->id = $musics->musicId;
        if (($checkIfCan = $this->isManager($musics))&&$checkIfCan['code']==0){
            return $checkIfCan;
        }
        //删除数据库的记录+删除存储桶上的文件+清空缓存
        $uriKey = $musics->uriKey;
        if ($musics->delete()){
            $cacheKey = config("cos")['cacheMusicKey'].$musics->musicId;
            $this->getRedisClient()->del($cacheKey);
            $this->removeCosFile(['key'=>$uriKey]);
            return ['code'=>1,'message'=>'删除成功！'];
        }
    }

    //屏蔽或限制分享
    function shieldOrShare(Musics $musics)
    {
        return $this->modelShieldOrShare($musics);
    }

    function play(Musics $musics)
    {
        return $this->playModel($musics);
    }
}
