<?php

namespace App\Http\Controllers\Admin;

use App\ReportUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class ReportUsersController extends Controller
{
    function index()
    {
        return view("admin.report.index");
    }

    function ajaxReports(Request $request,ReportUsers $reportUsers)
    {
        return $this->models(...[$request,$reportUsers,function (&$searchItem)use($request){
            if (!empty($request->query->get('name'))){
                $userIds = User::where("realName","LIKE","%".$request->query->get('name')."%")->pluck("userId");
                $searchItem['reportedUserId']   = count($userIds->toArray())>0?$userIds->toArray():'';
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['reportedUserId'])&&!empty($searchItem['reportedUserId'])){
                $query->whereIn("reportedUserId",$searchItem['reportedUserId']);
            }
        },function (&$item)use($reportUsers){

            $item->userName = User::where("userId","=",$item['userId'])->value("realName")?User::where("userId","=",$item['userId'])->value("realName"):User::where("userId","=",$item['userId'])->value("name");
            $item->reportUserName = User::where("userId","=",$item['reportedUserId'])->value("realName")?User::where("userId","=",$item['reportedUserId'])->value("realName"):User::where("userId","=",$item['reportedUserId'])->value("name");
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));

        }]);
    }

    function remove(ReportUsers $reports)
    {
        return $this->removeModel($reports);
    }
}
