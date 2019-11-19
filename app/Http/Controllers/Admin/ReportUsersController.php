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
                $userIds = User::where("name","LIKE","%".$request->query->get('name')."%")->pluck("userId");
                $searchItem['reportedUserId']   = count($userIds->toArray())>0?$userIds->toArray():'';
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['reportedUserId'])&&!empty($searchItem['reportedUserId'])){
                $query->whereIn("reportedUserId",$searchItem['reportedUserId']);
            }
        },function (&$item)use($reportUsers){
            if (isset($item->userName->realName)){
                $item->userName  = $item->userName->realName;
            }
            if (isset($item->userName->name)){
                $item->userName  = $item->userName->name;
            }else{
                $item->userName  = "";
            }
            if (isset($item->reportUserName->realName)){
                $item->reportUserName  = $item->reportUserName->realName;
            }
            if (isset($item->reportUserName->name)){
                $item->reportUserName  = $item->userName->name;
            }else{
                $item->reportUserName  = "";
            }
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));

        }]);
    }

    function remove(ReportUsers $reports)
    {
        return $this->removeModel($reports);
    }
}
