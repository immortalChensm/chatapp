<?php

namespace App\Http\Controllers\Admin;

use App\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    function index()
    {
        return view("admin.permission.index");
    }

    function permission(Request $request,Permissions $permissions)
    {
        return $this->models(...[$request,$permissions,function (&$searchItem)use($request){
            $searchItem['name']   = $request->query->get('name');
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("name","LIKE","%".$searchItem['name']."%");
            }
        }]);
    }

}
