<?php

namespace App\Http\Controllers\Admin;

use App\Reply;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepliesController extends Controller
{
    protected $typeTable       = ['1' => 'articles', '2' => 'photos', '3' => 'musics', '4' => 'videos'];
    protected $typeTitle       = ['1' => '文章', '2' => '相册', '3' => '音乐', '4' => '视频'];
    protected $typeField       = ['1' => 'articleId', '2' => 'photoId', '3' => 'musicId', '4' => 'videoId'];

    function index()
    {
        return view("admin.replies.index");
    }
    function replies(Request $request,Reply $reply)
    {
        return $this->models(...[$request,$reply,function (&$searchItem)use($request){
            $searchItem['content']   = $request->query->get('content');
            if (!empty($request->query->get('name'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('name')."%")->pluck("userId");
                $searchItem['userId']   = count($userIds->toArray())>0?$userIds->toArray():'';
            }
        },function ($query,&$searchItem){
            if ($searchItem['content']){
                $query->where("content","LIKE","%".$searchItem['content']."%");
            }
            if (isset($searchItem['userId'])&&!empty($searchItem['userId'])){
                $query->whereIn("userId",$searchItem['userId']);
            }
            $query->where("isDeleted","=",0);//软删除
        },function (&$item){
            $item->userName        = User::where("userId", $item['userId'])->value("name");
            $item->replyUserName   = User::where("userId", $item['commentUserId'])->value("name");
            $item->createdDate     = date("Y-m-d H", strtotime($item->created_at));
            $item->isShow = $item->isShow==1?'否':'是';

        }]);
    }

    function shieldOrShare(Reply $reply)
    {
        return $this->modelShieldOrShare($reply);
    }
    function remove(Reply $reply)
    {
        return $this->removeModel($reply,2);
    }
}
