<?php

namespace App\Http\Controllers\Admin;

use App\Groups;
use App\ReportGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class ReportGroupsController extends Controller
{
    function index()
    {
        return view("admin.groups.report");
    }

    function ajaxReports(Request $request,ReportGroup $reportGroup)
    {
        return $this->models(...[$request,$reportGroup,function (&$searchItem)use($request){
            if (!empty($request->query->get('name'))){
                $Ids = Groups::where("Name","LIKE","%".$request->query->get('name')."%")->pluck("GroupId");
                $searchItem['groupId']   = count($Ids->toArray())>0?$Ids->toArray():'';
            }
        },function ($query,&$searchItem){
            if (isset($searchItem['groupId'])&&!empty($searchItem['groupId'])){
                $query->whereIn("groupId",$searchItem['groupId']);
            }
        },function (&$item)use($reportGroup){
            $item->userName  = User::where("userId","=",$item['userId'])->value("realName")?User::where("userId","=",$item['userId'])->value("realName"):User::where("userId","=",$item['userId'])->value("name");
            $item->reportGroupName  = Groups::where("groupId",$item->groupId)->value("Name");
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));

        }]);
    }

    function remove(ReportGroup $reportGroup)
    {
        return $this->removeModel($reportGroup);
    }
}
