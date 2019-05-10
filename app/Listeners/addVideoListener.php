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
        $video = $event->videoModel;
        $cosFile = downloadCosFile([
            'fileKeyName'=>$video['uriKey'],
            'expire'=>config('cos')['expire']
        ]);
        $ffmpeg = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
        $video = $ffmpeg->open($cosFile['data']);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(5));
        $localFileSrc = config("upload")['attachedDir']."/".$video['uriKey'];
        $frame->save($localFileSrc);
    }
}
