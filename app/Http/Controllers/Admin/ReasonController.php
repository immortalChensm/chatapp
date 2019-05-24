<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreReasonPost;
use App\Reason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReasonController extends Controller
{
    function index()
    {
        return view("admin.reason.index");
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
