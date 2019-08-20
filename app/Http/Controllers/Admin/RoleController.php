<?php

namespace App\Http\Controllers\Admin;

use App\ArticleTag;
use App\Http\Requests\Admin\StoreArticleTagPost;
use App\Http\Requests\Admin\StoreRolePost;
use App\Permissions;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{

    function index()
    {
        return view("admin.role.index");
    }

    function roles(Request $request,Role $role)
    {
        return $this->models(...[$request,$role,function (&$searchItem)use($request){
            $searchItem['name']   = $request->query->get('name');
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("name","LIKE","%".$searchItem['name']."%");
            }
        }]);
    }

    function edit()
    {
        isset(request()->id)?$data=Role::where("id","=",request()->id)->first():$data='';
        $permission = Permissions::all();
        $formatPermission = [];
        foreach ($permission as $k=>$item){
            $formatPermission[$item['group']][$item['id']] = $item['name'];
        }
        if ($data){
            $data['permissionIds'] = json_decode($data['permissionIds'],true);
        }

        return view("admin.role.edit",compact('data','formatPermission'));
    }

    function store(StoreRolePost $request)
    {
        $request['permissionIds'] = json_encode($request['permissionIds']);
        return empty($request->id)?(Role::create($request->except("_token","s"))?['code'=>1,'message'=>'添加成功']:['code'=>0,'message'=>'添加失败']):
            (Role::where("id","=",$request->id)->update([
                'name'=>$request['name'],
                'description'=>$request['description'],
                'permissionIds'=>$request['permissionIds']
            ])?['code'=>1,'message'=>'更新成功']:['code'=>0,'message'=>'更新失败']);
    }

    function remove(Role $role)
    {
        return $this->removeModel($role);
    }
}
