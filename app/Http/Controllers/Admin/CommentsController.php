<?php

namespace App\Http\Controllers\Admin;

use App\Comments;
use App\Http\Requests\Admin\StoreReasonPost;
use App\Reason;
use App\Reports;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    protected $typeTable       = ['1' => 'articles', '2' => 'photos', '3' => 'musics', '4' => 'videos'];
    protected $typeTitle       = ['1' => '文章', '2' => '相册', '3' => '音乐', '4' => '视频'];
    protected $typeField       = ['1' => 'articleId', '2' => 'photoId', '3' => 'musicId', '4' => 'videoId'];

    function index()
    {
        return view("admin.comments.index");
    }


    function comments(Request $request,Comments $comments)
    {
        return $this->models(...[$request,$comments,function (&$searchItem)use($request){
            $searchItem['content']   = $request->query->get('content');

            if (!empty($request->query->get('userName'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('userName')."%")->pluck("userId");
                $temp = [];
                if (count($userIds)>0){
                    foreach($userIds as $userId){
                        $temp[] = $userId;
                    }
                    $searchItem['userId']   = implode(",",$temp);
                }
            }



        },function ($query,&$searchItem){
            if ($searchItem['content']){
                $query->where("content","LIKE","%".$searchItem['content']."%");
            }
            if ($searchItem['userId']){
                $query->whereIn("userId",$searchItem['userId']);
            }
        },function (&$item){
            $item->userName        = User::where("userId", $item['userId'])->value("name");
            $item->createdDate     = date("Y-m-d H", strtotime($item->created_at));
            $item->title           = DB::table($this->typeTable[$item->modelType])->value("title");
            $item->commentPraise   = $item['praise'];
            $item->commentUserName = User::where("userId", $item['ownerUserId'])->value("name");
            $item->typeName        = $this->typeTitle[$item->modelType];
            $item->commentReply    = count($item->reply);
        }]);
    }


    function remove(Comments $comments)
    {
        return $this->removeModel($comments);
    }
}
