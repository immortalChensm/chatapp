<?php

namespace App\Http\Controllers\Admin;

use App\Events\addVideo;
use App\Http\Requests\Admin\StoreVideoPost;
use App\Videos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
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
            //$searchItem['userId']   = User::where("realName","=",request("user"))->orWhere('name',"=",request("user"))->value("userId");
        },function ($query,&$searchItem){
            if ($searchItem['title']){
                $query->where("title","LIKE","%".$searchItem['title']."%");
            }
//            if ($searchItem['userId']){
//                $query->where("userId","=",$searchItem['userId']);
//            }
        },function (&$item){
            if ($item->userType==2){
                $item->userId      = "平台发布";
                $item->userIdMsg = 0;
            }else{
                $item->userIdMsg = $item['userId'];
                $item->userId      = User::where("userId","=",$item['userId'])->value("realName")?User::where("userId","=",$item['userId'])->value("realName"):User::where("userId","=",$item['userId'])->value("name");
            }
            $item->isShowFlag      = $item->isShow ;
            $item->isShow      = $item->isShow == 0 ? '是' : '否';
            $item->canSharedFlag   = $item->canShared;
            $item->canShared   = $item->canShared == 1 ? '是' : '否';
            $item->isStoraged  = $item->isStoraged == 1 ? '是' : '否';

            if (empty($item->expire)){
                $item->expire = "";
            }else{
                //已置顶且未过期
                if ($item->top==1&&time()<($item->topStartTime+($item->expire*3600))){
                    $item->expire = $item->expire."[未过期]";
                }else if ($item->top==1&&time()>($item->topStartTime+($item->expire*3600))){
                    //已置顶且过期
                    Videos::where("videoId","=",$item->videoId)->update(['top'=>0,'topStartTime'=>0,'expire'=>0,'topNumber'=>0]);
                    $item->expire = "[过期]";
                }else{
                    $item->expire = "";
                }

            }
            //是否置顶
            $item->top  = $item->top == 1 ? '是' : '否';
            //置顶开始时间
            if ($item->topStartTime){
                $item->topStartTime = date("Y-m-d H", $item->topStartTime);
            }else{
                $item->topStartTime = "";
            }
            if (empty($item->topNumber)){
                $item->topNumber = 0;
            }
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
                event(new addVideo(['videoId'=>$request->videoId,'uriKey'=>$request->uriKey]));
            }
            return $result;

        }else {
            $addRet = Videos::create(array_merge($prepareData,[
                'userId'       => 1,
                'userType'     => 2,
                'isShared'=>1,
                'sharedLocation'=>'12',
                'isShow'=>1
            ]));
            if ($addRet){
                event(new addVideo(['videoId'=>$addRet['videoId'],'uriKey'=>$addRet['uriKey']]));
                $ret = ['code' => 1, 'message' => '添加成功'];
            }else{
                $ret = ['code' => 0, 'message' => '添加失败'];
            }
            return $ret;
        }
    }

    function remove(Videos $videos)
    {
        $videos->id = $videos->videoId;
//        if (($checkIfCan = $this->isManager($videos))&&$checkIfCan['code']==0){
//            return $checkIfCan;
//        }
        //删除数据库的记录+删除存储桶上的文件+清空缓存
        $uriKey = $videos->uriKey;
        if ($videos->delete()){
            //$cacheKey = config("cos")['cacheMusicKey'].$videos->videoId;
            //$this->getRedisClient()->del($cacheKey);
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


    /**
     * 移除存储桶上的视频 连同封面一起
     * @return \Illuminate\Http\JsonResponse
     */
    function removeVideoFile()
    {
        $file = explode(".",request('fileKeyName'));
        if ($this->removeCosFile(['key'=>request('fileKeyName')])['code']==1){
            $this->removeCosFile(['key'=>$file[0].".png"]);
            return response()->json(['code'=>1,'message'=>'移除成功']);
        }

    }
    /**
     * 获取存储桶上的文件视频uri
     * @return array
     */
    function getVideoCosUri()
    {
        $retUri = $this->downloadCosFile(['fileKeyName'=>request('fileKeyName'),'expire'=>config('cos')['expire']]);
        return $retUri['code']==1?['code'=>1,'message'=>$retUri['data']]:['code'=>0,'message'=>'获取失败'];
    }


}
