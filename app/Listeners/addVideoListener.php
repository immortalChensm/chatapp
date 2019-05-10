<?php

namespace App\Listeners;
use App\Events\addVideo;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class addVideoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  addVideo  $event
     * @return void
     */
    public function handle(addVideo $event)
    {
        $videoFile    = $event->videoModel;
        $localFileSrc = config("upload")['attachedDir'] . "/" . str_replace('/', '', $videoFile['uriKey']);
        $cosFile      = downloadCosFileSavelocal($videoFile['uriKey'], $localFileSrc);
        $ffmpeg       = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
        $video = $ffmpeg->open($cosFile['data']);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(5));
        $localFileSrcCover = config("upload")['attachedDir']."/".str_replace('/','',(function($videoFile){
                $videoSrc = explode('.',$videoFile['uriKey']);
                return str_replace('/','',$videoSrc[0]);
            })($videoFile)).".png";
        $frame->save($localFileSrcCover);
        $this->uploadCoverFileAndSave(explode(".",str_replace('/','',$videoFile['uriKey']))[0].".png",$localFileSrcCover,$videoFile,$localFileSrc);

    }

    private function uploadCoverFileAndSave($uriKey,$localFileSrcCover,$videoFile,$localFileSrc)
    {
        $key = "other/".substr($uriKey,strlen("other"));
        $ret = uploadCosFile([
            'fileKeyName'=>$key,
            'file'=>$localFileSrcCover
        ]);
        if ($ret['code']==1){
            DB::table("videos")->where("videoId","=",$videoFile['videoId'])->update(['cover'=>$key]);
            //删除本地文件
            $fileSystem = new Filesystem();
            if ($fileSystem->exists($localFileSrc)){
                $fileSystem->delete($localFileSrc);
            }
            if ($fileSystem->exists($localFileSrcCover)){
                $fileSystem->delete($localFileSrcCover);
            }
        }
    }
}
