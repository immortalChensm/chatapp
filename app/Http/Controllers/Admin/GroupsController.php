<?php

namespace App\Http\Controllers\Admin;

use App\Groups;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
    //
    function index()
    {
        return view("admin.groups.index");
    }

    function groups(Request $request,Groups $groups)
    {
        return $this->models(...[$request,$groups,function (&$searchItem)use($request){
            $searchItem['name']       = $request->name;
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("GroupId","=",$searchItem['name']);
            }

        },function (&$item){
            $item->Owner_Name = User::where("userId",$item->Owner_Account)->value("name");
            $item->createdDate = date("Y-m-d H", $item->CreateTime);
        }]);
    }

    function remove(Groups $groups)
    {
        if($groups->delete()){
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }

    /**
     * IM群内消息发送
     * @param Request $request
     * @return array
     */
    function groupSendMsg(Request $request)
    {
        if (empty($request['Text']))return ['code'=>0,'message'=>'请填写消息内容'];
        $result = $this->getApi("POST","api/im/group/sendMsg",request()->except(['s','_token']));
        return ['code'=>1,'message'=>$result];
    }

    /**IM群删除即解散
     * @param Request $request
     * @return array
     */
    function destroyGroup(Request $request)
    {
        if (empty($request['groupId']))return ['code'=>0,'message'=>'请选择要解散的群'];
        $result = $this->getApi("POST","api/im/group/destroy",request()->except(['s','_token']));
        return ['code'=>1,'message'=>$result];
    }

}
