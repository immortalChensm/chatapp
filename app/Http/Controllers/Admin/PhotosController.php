<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StorePhotoPost;
use App\Images;
use App\Photos;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * 相册列表
     */
    function index()
    {
        return view("admin.photos.index");
    }

    function edit()
    {
        if(isset(request()->photoId)){
            $photo = Photos::where("photoId","=",request()->photoId)->first();
            $uriKeys = $photo->images;
            //从缓存里取出相册
            $cacheKey = config("cos")['cachePhotoKey'].$photo->photoId;
            if ($this->getRedisClient()->exists($cacheKey)){
                $uriFiles = unserialize($this->getRedisClient()->get($cacheKey));
                //判断缓存里的照片数量和数据库的数量是否对应
                if (count($uriFiles) != count($uriKeys)){
                    $uriFiles = $this->downLoadCosFileAndCache($uriKeys,$cacheKey);
                }
            }else{
                $uriFiles = $this->downLoadCosFileAndCache($uriKeys,$cacheKey);
            }
            $photo['uriKey'] = $uriFiles;

        }
        $data = isset($photo)?$photo:'';
        return view("admin.photos.edit",compact('data'));
    }

    /**
     * 从存储桶下载文件并缓存
     * @param $uriKeys
     * @param $cacheKey
     * @return array
     */
    private function downLoadCosFileAndCache($uriKeys,$cacheKey)
    {
        $uriFiles = [];
        if (count($uriKeys)>0){
            foreach($uriKeys as $item){
                $result = $this->downloadCosFile([
                    'fileKeyName'=>$item->uriKey,
                    'expire'=>config('cos')['expire']
                ]);
                if ($result['code']==1){
                    $uriFiles[$item->uriKey] = $result['data'];
                }
            }
        }
        $this->getRedisClient()->set($cacheKey,serialize($uriFiles),config('cos')['cacheTime']);
        return $uriFiles;
    }

    function photos(Request $request,Photos $photos)
    {
        return $this->models(...[$request,$photos,function (&$searchItem)use($request){
            $searchItem['title']   = $request->query->get('title');
        },function ($query,&$searchItem){
            if ($searchItem['title']){
                $query->where("title","LIKE","%".$searchItem['title']."%");
            }
        },function (&$item){
            if ($item->userType==2){
                $item->userId      = "平台发布";
                $item->userIdMsg = 0;
            }else{
                $item->userIdMsg = $item['userId'];
                $item->userId      = User::where("userId","=",$item['userId'])->value("name");
            }
            $item->isShowFlag      = $item->isShow ;
            $item->isShow      = $item->isShow == 0 ? '是' : '否';
            $item->canSharedFlag   = $item->canShared;
            $item->canShared  = $item->canShared == 1 ? '是' : '否';
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function store(StorePhotoPost $request)
    {
        $prepareData = [
            'title'=>$request->title,
            'introduction'=>$request->introduction
        ];
        if (isset($request->photoId)){

            //如果是用户发布的相册禁止修改
            $photo=Photos::where("photoId","=",$request->photoId)->first();
            $photo->id = $photo->photoId;
            if (($checkCan = $this->isManager($photo))&&$checkCan['code']==0){
                return $checkCan;
            }
            //如果是修改自己的
           if (Photos::where("photoId","=",$request->photoId)->update($prepareData)){
               $updateResult = $this->insertImageFile($request,$photo,'update')?['code'=>1,'message'=>'更新成功']:['code'=>1,'message'=>'更新失败'];
               $cacheKey = config("cos")['cachePhotoKey'].$photo->photoId;
               $this->downLoadCosFileAndCache(Images::where("photoId","=",$photo->photoId)->get(),$cacheKey);
               return $updateResult;
           }
        }else{
                if ($photo = Photos::create(array_merge($prepareData,[
                    'userId'=>1,
                    'userType'=>2,
                    'isShared'=>1,
                    'sharedLocation'=>'12',
                    'isShow'=>1
                ]))){
                    return $this->insertImageFile($request,$photo,'insert')?['code'=>1,'message'=>'添加成功']:['code'=>1,'message'=>'添加失败'];

                }
        }
    }

    /**
     * 插入的照片禁止重复
     * @param $request
     * @param $photo
     * @param $operateFlag
     * @return mixed
     */
    private function insertImageFile($request,$photo,$operateFlag)
    {
        $data = [];
        foreach($request->uriKey as $uri){
            $temp['photoId'] = $photo->photoId;
            $temp['type'] = 1;
            $temp['uriKey'] = $uri;
            array_push($data,$temp);
        }
        if ($operateFlag == 'update'){
            $oldImage = Images::where("photoId","=",$photo->photoId)->get();
            foreach ($oldImage as $item){
                foreach ($data as $k=>$newItem){
                    if ($item->photoId == $newItem['photoId'] && $item->uriKey==$newItem['uriKey']){
                        unset($data[$k]);
                    }
                }
            }

        }
        return Images::insert($data);
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

    //屏蔽或限制分享
    function shieldOrShare(Photos $photos)
    {
        return $this->modelShieldOrShare($photos);
    }

}
