<?php

namespace App\Http\Controllers\Admin;

use App\ReportUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportUsersController extends Controller
{
    function index()
    {
        return view("admin.report.index");
    }

    function ajaxReports(Request $request,ReportUsers $reports)
    {
        return $this->models(...[$request,$reports,function (&$searchItem)use($request){
            if (!empty($request->query->get('name'))){
                $userIds = User::where("name","LIKE","%".$request->query->get('name')."%")->pluck("userId");
                $searchItem['reportedUserId']   = count($userIds->toArray())>0?$userIds->toArray():'';
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['userId'])&&!empty($searchItem['userId'])){
                $query->whereIn("userId",$searchItem['userId']);
            }
        },function (&$item)use($reports){
            $item->userName  = isset($item->userName->realName)?$item->userName->realName:$item->userName->name;
            $item->reportUserName  = isset($item->reportUserName->realName)?$item->reportUserName->realName:$item->reportUserName->name;
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));

        }]);
    }

    function remove(ReportUsers $reports)
    {
        return $this->removeModel($reports);
    }
}
