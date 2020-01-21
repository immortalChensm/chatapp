<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreReasonPost;
use App\Reason;
use App\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReasonController extends Controller
{
    protected $typeTable       = ['1' => 'articles', '2' => 'photos', '3' => 'musics', '4' => 'videos'];
    protected $typeTitle       = ['1' => '文章', '2' => '相册', '3' => '音乐', '4' => '视频'];
    protected $typeField       = ['1' => 'articleId', '2' => 'photoId', '3' => 'musicId', '4' => 'videoId'];

    function index()
    {
        return view("admin.reason.index");
    }

    function reports()
    {
        $data = Reason::all();
        return view("admin.reason.reports",compact('data'));
    }

    function ajaxReports(Request $request,Reports $reports)
    {
        return $this->models(...[$request,$reports,function (&$searchItem)use($request){
            $searchItem['reasonId']   = $request->query->get('reasonId');
        },function ($query,&$searchItem){
            if ($searchItem['reasonId']){
                $query->where("reasonId",$searchItem['reasonId']);
            }
        },function (&$item)use($reports){
            if ($item->reasonName){
                $item->reasonName      = $item->reasonName->reason;
            }else{
                $item->reasonName      = "";
            }

            $item->userName  = User::where("userId", $item['userId'])->value("realName")?User::where("userId", $item['userId'])->value("realName"):User::where("userId", $item['userId'])->value("name");
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
            $item->title = DB::table($this->typeTable[$item->modelType])->value("title");
            $item->reportUserId = DB::table($this->typeTable[$item->modelType])->value("userId");
            $item->typeName = $this->typeTitle[$item->modelType];
        }]);
    }

    /**
     * 消息发送接口【警告用】
     * @param Request $request
     * @return array
     */
    function sendMessage(Request $request)
    {
        if (empty($request['content']))return ['code'=>0,'message'=>'请填写消息内容'];
        $result = $this->getApi("POST","api/im/sendMsg",request()->except(['s','_token']));
        return ['code'=>1,'message'=>$result];
    }

    function getAllData()
    {

    }

    function removeReport(Reports $reports)
    {
        return $this->removeModel($reports);
    }

    function reasons(Request $request,Reason $reason)
    {
        return $this->models(...[$request,$reason,function (&$searchItem)use($request){
            $searchItem['reason']   = $request->query->get('reason');
        },function ($query,&$searchItem){
            if ($searchItem['reason']){
                $query->where("reason","LIKE","%".$searchItem['reason']."%");
            }
        }]);
    }

    function edit()
    {
        isset(request()->id)?$data=Reason::where("id","=",request("id"))->first():$data='';
        return view("admin.reason.edit",compact('data'));
    }

    function store(StoreReasonPost $request)
    {
        return empty($request->id)?(Reason::create($request->except("_token","s"))?['code'=>1,'message'=>'添加成功']:['code'=>0,'message'=>'添加失败']):
            (Reason::where("id","=",$request->id)->update(['reason'=>$request->reason])?['code'=>1,'message'=>'更新成功']:['code'=>0,'message'=>'更新失败']);
    }

    function remove(Reason $reason)
    {
        return $this->removeModel($reason);
    }
}
