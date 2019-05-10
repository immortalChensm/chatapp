<?php

namespace App\Listeners;

use App\Events\addVideo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $videoFile = $event->videoModel;
        $localFileSrc = config("upload")['attachedDir']."/".str_replace('/','',$videoFile['uriKey']);
        $cosFile = downloadCosFileSavelocal($video['uriKey'],$localFileSrc);
        $ffmpeg = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
        $video = $ffmpeg->open($cosFile['data']);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(5));
        $localFileSrcCover = config("upload")['attachedDir']."/".str_replace('/','',(function($video){
                $videoSrc = explode('.',$video['uriKey']);
                return str_replace('/','',$videoSrc[0]);
            })($videoFile)).".png";
        $frame->save($localFileSrcCover);
    }
}
