<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PHPHtmlParser\Dom;
use Qcloud\Cos\Client;
use Upload\File;
use Upload\Storage\FileSystem;
use Upload\Validation\Size;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 上传文件
     */
//    function upload()
//    {
//        $storage = new FileSystem(config("upload")['attachedDir']);
//        ($file = new File("imgFile",$storage))->setName(uniqid());
//        $file->addValidations([
//            new Size(env("UPLOAD_MAX_FILESIZE"))
//        ]);
//
//        if (request()->get("dir")!=null){
//            if (in_array(config("upload"), config("upload")[request()->get("dir")]) === false) {
//                $result = [
//                    'error'=>1,
//                    'message'=>'上传的文件扩展不允许'
//                ];
//            }
//        }
//        try {
//            if($file->upload()){
//                $result = [
//                    'error'=>0,
//                    'url'=>asset("attached/".$file->getNameWithExtension()),
//                    'file'=>config("upload")['attachedDir']."/".$file->getNameWithExtension()
//                ];
//            }
//            //上传成功的文件全扔到存储桶里
//            if ($result['error'] == 0&&!preg_match('/apk|IPA/',$result['url'])){
//                $fileKeyName = "other/".$file->getNameWithExtension();
//                $localFileSrc = config("upload")['attachedDir']."/".$file->getNameWithExtension();
//                $cosUpload = $this->uploadCosFile([
//                    'fileKeyName'=>$fileKeyName,
//                    'file'=>$localFileSrc
//                ]);
//                //$videoImageSrc = $this->videoCoverResolve($fileKeyName,$localFileSrc);
//                if ($cosUpload['code']==1){
//                    //删除本地的文件，获取存储桶上的文件uri
//                    if ($this->getFileSystem()->exists($localFileSrc))$this->getFileSystem()->delete($localFileSrc);
//                    $cosFile = $this->downloadCosFile(['fileKeyName'=>$fileKeyName,'expire'=>config("cos")['expire']]);
//                    $result = [
//                        'error'=>0,
//                        'url'=>$cosFile['data'],
//                        'fileKeyName'=>$fileKeyName
//                    ];
//                }else{
//                    //上传失败
//                    $result = [
//                        'error'=>1,
//                        'message'=>'上传失败请重试！'
//                    ];
//                }
//            }
//
//
//        } catch (\Exception $e) {
//            $result = [
//              'error'=>1,
//              'message'=>$file->getErrors()
//            ];
//        }
//        if (!empty($videoImageSrc)){
//            $result['videoImageSrc'] = $videoImageSrc;
//        }
//        return $result;
//
//    }

//移动到自己的服务器
    function upload()
    {
        $storage = new FileSystem(config("upload")['attachedDir']);

        if(!preg_match("/.apk/",$_FILES['imgFile'])){
            ($file = new File("imgFile",$storage))->setName(uniqid());
        }else{
            ($file = new File("imgFile",$storage))->setName("传联");
        }

        $file->addValidations([
            new Size(env("UPLOAD_MAX_FILESIZE"))
        ]);

        if (request()->get("dir")!=null){
            if (in_array(config("upload"), config("upload")[request()->get("dir")]) === false) {
                $result = [
                    'error'=>1,
                    'message'=>'上传的文件扩展不允许'
                ];
            }
        }
        try {
            if($file->upload()){
                $result = [
                    'error'=>0,
                    'url'=>asset("attached/".$file->getNameWithExtension()),
                    'file'=>config("upload")['attachedDir']."/".$file->getNameWithExtension()
                ];
            }
            //上传成功的文件全扔自个儿的服务器
            if ($result['error'] == 0&&!preg_match('/apk|IPA/',$result['url'])){
                $fileKeyName = $file->getNameWithExtension();
                $localFileSrc = config("upload")['attachedDir']."/".$file->getNameWithExtension();
                $cosUpload = $this->uploadFileToSelfService([
                    'fileKeyName'=>$fileKeyName,
                    'file'=>$localFileSrc
                ]);

                if ($cosUpload['code']==200){
                    //删除本地的文件，获取上传的文件uri
                    if ($this->getFileSystem()->exists($localFileSrc))$this->getFileSystem()->delete($localFileSrc);
                    //$cosFile = $this->downloadCosFile(['fileKeyName'=>$fileKeyName,'expire'=>config("cos")['expire']]);

                    $result = [
                        'error'=>0,
                        'url'=>$cosUpload['file'],
                        'fileKeyName'=>$fileKeyName
                    ];
                }else{
                    //上传失败
                    $result = [
                        'error'=>1,
                        'message'=>'上传失败请重试！'
                    ];
                }
            }


        } catch (\Exception $e) {
            $result = [
                'error'=>1,
                'message'=>$file->getErrors()
            ];
        }
        if (!empty($videoImageSrc)){
            $result['videoImageSrc'] = $videoImageSrc;
        }
        return $result;

    }

    //上传文件到自个儿的服务器
    function uploadFileToSelfService($file)
    {

        $client = new \GuzzleHttp\Client([
            'base_uri'=>config("cos")['removeFileUri'],
            'verify' => false
        ]);

        $response = $client->request('POST', 'api/image/upload', [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($file['file'], 'r'),
                    'filename' => $file['fileKeyName'],
                    'headers'  => [
                        'X-Foo' => 'this is an extra header to include'
                    ]
                ]
            ]
        ]);
        return json_decode($response->getBody()->getContents(),true);
    }
    private function videoCoverResolve($fileKeyName,$localFileSrc)
    {

        if (preg_match('/\.mp4|\.avi/',$fileKeyName)){
            $imageFileSrc = config("upload")['attachedDir']."/".date("YmdHis").".png";
            $this->getVideoImage($localFileSrc,$imageFileSrc);
            return $imageFileSrc;
        }
        return null;

    }

    function getFileSystem()
    {
        return new \Illuminate\Filesystem\Filesystem();
    }
    /**
     * 得到redis客户端
     * @return \Redis|null
     */
    function getRedisClient()
    {
        $redis = new \Redis();
        if($redis->connect(env("REDIS_HOST"),env("REDIS_PORT"))){
            $redis->auth(env("REDIS_PASSWORD"));
            return $redis;
        }else{
            return $redis->connect(env("REDIS_HOST"),env("REDIS_PORT"));
        }

    }

    /**
     * @return Client OSS
     */
    function getCosClient()
    {
        return getCosClient();

    }

    /**
     * 上传文件到腾迅云存储桶
     * @param $data [fileKeyName]文件key名称
     * file文件的绝对路径
     * @return \Exception
     */
    function uploadCosFile($data)
    {

        ### 上传文件流
//        try {
//            $result = $this->getCosClient()->putObject(array(
//                'Bucket' => config("cos")['bucket'],
//                'Key' => $data['fileKeyName'],
//                'Body' => fopen($data['file'], 'rb')));
//            $data = ['code'=>1,'data'=>$result];
//        } catch (\Exception $e) {
//            $data = ['code'=>0,'data'=>$e];
//        }
//        return $data;

        return uploadCosFile($data);
    }

    /**下载存储桶里的文件【腾迅对象存储服务】
     * @param $data  [fileKeyName] 要获取的文件key名称
     * expire 文件的过期时间
     */
    function downloadCosFile($data)
    {
//        try {
//            $signedUrl = $this->getCosClient()->getObjectUrl(config("cos")['bucket'], $data['fileKeyName'], $data['expire']?$data['expire']:'+10 minutes');
//            $result = ['code'=>1,'data'=>$signedUrl];
//        } catch (\Exception $e) {
//            $result = ['code'=>0,'data'=>$e];
//        }
//        return $result;
          return downloadCosFile($data);
    }

    /**
     * 删除存储桶上的文件
     * 必须是带有后缀的文件名，否则删除不了
     */
    function removeCosFile($data)
    {
        //return deleteCosFile($data);
        $client = new \GuzzleHttp\Client([
            'base_uri'=>config("cos")['removeFileUri'],
            'verify' => false
        ]);
        $response = $client->request("POST","api/image/remove",[
            'form_params'=>$data
        ]);

        return json_decode($response->getBody()->getContents(),true);
    }

    /**
     * 下载存储桶的文件并保存
     * @param $key
     * @param $localPath
     * @return array
     */
    function downloadCosFileSavelocal($key,$localPath)
    {
//        try {
//                 $localPath = @$localPath;
//                 $result = $this->getCosClient()->getObject([
//                        'Bucket' => config("cos")['bucket'],
//                        'Key' => $key,
//                        'SaveAs' => $localPath]
//                 );
//                 $result = ['code'=>1,'data'=>$localPath];
//            } catch (\Exception $e) {
//                    // 请求失败
//                 $result = ['code'=>0,'data'=>$e];
//           }
//            return $result;
        return downloadCosFileSavelocal($key,$localPath);
    }

    /**
     * 屏蔽或限制分享
     * @param Model $model
     * @return array
     */
    function modelShieldOrShare(Model $model)
    {
        $field = [
            '1'=>'isShow',
            '2'=>'canShared'
        ];
        return $model->update([$field[request()->type]=>!$model->{$field[request()->type]}])?['code'=>1,'message'=>'操作成功']:['code'=>0,'message'=>'操作失败'];
    }

    function isManager(Model $model)
    {
        $data = $model::where($model->primaryKey,"=",$model->id)->first();
        if ($data->userType==1){
            return ['code'=>0,'message'=>'用户发布的数据禁止操作！'];
        }else{
            return ['code'=>1];
        }
    }

    function models($request,Model $model,\Closure $searchCallback,\Closure $queryCallback,\Closure $dataResolveCallback=null)
    {
        $draw        = $request->query->get('draw');
        $orderColumn = $request->query->get('order')['0']['column'];
        $orderDir    = $request->query->get('order')['0']['dir'];
        $fields      = $request->query->get('columns');
        $fieldName   = [];
        if (count($fields)>0){
            foreach ($fields as $key=>$item) {
                $fieldName[$key] = $item['name'];
            }
        }

        $orderSql = "";
        if (isset($orderColumn)) {
            $orderSql = " {$fieldName[intval($orderColumn)]} " . $orderDir;
        }
        $searchItem = [];$searchCallback($searchItem);
        $start  = $request->query->get('start');//从多少开始
        $length = $request->query->get('length');//数据长度
        $recordsTotal = $model->count($model->primaryKey);
        if (!in_array($model->getTable(),['permissions','roles','managers'])){
            $data         = $model->where(function ($query) use ($searchItem,$queryCallback) {
                $queryCallback($query,$searchItem);

            })->orderByRaw("created_at desc,".$orderSql);
        }else{
            $data         = $model->where(function ($query) use ($searchItem,$queryCallback) {
                $queryCallback($query,$searchItem);

            });
        }

        $recordsFiltered = $data->count($model->primaryKey);
        $infos           = $data->skip($start)->take($length)->get();
        $infos->map(function ($item)use($dataResolveCallback){
            if ($dataResolveCallback!=null){
                $dataResolveCallback($item);
            }
        });

        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => $infos->toArray()
        ],200);
    }

    function removeModel(Model $model,$type=1)
    {
        if($type==1){
            return $model->delete()?['code'=>1,'message'=>'删除成功']:['code'=>0,'message'=>'删除失败'];
        }elseif($type==2){
            return $model->update(['isDeleted'=>1])?['code'=>1,'message'=>'删除成功']:['code'=>0,'message'=>'删除失败'];
        }

    }

    function getDomObj($html)
    {
        ($dom=new Dom())->load($html);
        return $dom;
    }

    /**
     * 获取视频图片
     * @param $sourceFile 视频文件
     * @param $coverFileName  图片文件
     */
    function getVideoImage($sourceFile,$coverFileName)
    {
        $ffmpeg = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
        $video = $ffmpeg->open($sourceFile);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(5));
        $frame->save($coverFileName);
    }

    function playModel(Model $model)
    {
//        $uri = $this->downloadCosFile([
//            'fileKeyName'=>$model['uriKey'],
//            'expire'=>config('cos')['expire']
//        ])['data'];
        //return $uri?['code'=>1,'message'=>$uri]:['code'=>0,'message'=>'链接失效请重试'];
        return ['code'=>1,'message'=>$model['uriKey']];
    }

    function getApi($method,$uri,$data=[])
    {
        $client = new \GuzzleHttp\Client([
            'base_uri'=>config("imapi")['base_uri'],
            'verify' => false
        ]);
        switch ($method){
            case 'POST':
                $response = $client->request("POST",$uri,[
                    'form_params'=>$data
                ]);
                break;
            case 'GET':
                $response = $client->request("GET",$uri);
                break;
        }
        return json_decode($response->getBody()->getContents(),true);
    }

}
