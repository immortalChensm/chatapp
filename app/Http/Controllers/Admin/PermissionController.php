<?php

namespace App\Http\Controllers\Admin;

use App\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;

class PermissionController extends Controller
{

    function index()
    {
        /** @var Route $route */
        $route = app(Route::class);
        //echo substr($route->getActionName(),strripos($route->getActionName(),"\\")+1);
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
