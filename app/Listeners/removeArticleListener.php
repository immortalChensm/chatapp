<?php

namespace App\Listeners;

use App\Events\removeArticle;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use PHPHtmlParser\Dom;

class removeArticleListener
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
     * @param  removeArticle  $event
     * @return void
     */
    public function handle(removeArticle $event)
    {
        //删除文件的附件
        $dom = new Dom();
        $dom->load($event->article);
        $picFiles = $dom->find("img");
        $videoFiles = $dom->find("embed");
        $fileSystem = new Filesystem();
       foreach ($picFiles as $file){
           $src = $file->getAttribute("src");
           if ($fileSystem->exists(public_path()."/".$src)){
               $fileSystem->delete(public_path()."/".$src);
           }
           preg_match_all('/other(.*)\?/',$src,$match);
           if ($match[1][0]){
               deleteCosFile(['key' => "other".$match[1][0]]);
           }
       }
        foreach ($videoFiles as $file){
            $src = $file->getAttribute("src");
            if ($fileSystem->exists(public_path()."/".$src)){
                $fileSystem->delete(public_path()."/".$src);
            }
            preg_match_all('/other(.*)\?/',$src,$match);
            if ($match[1][0]){
                deleteCosFile(['key' => "other".$match[1][0]]);
            }

        }
        return true;

    }
}
