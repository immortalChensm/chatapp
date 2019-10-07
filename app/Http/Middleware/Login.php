<?php

namespace App\Http\Middleware;

use App\Permissions;
use App\Role;
use Closure;
use Illuminate\Routing\Route;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //取得登录账号的权限
        if (session()->exists("loginUser")){
            $loginUser = session("loginUser");
            $role = json_decode($loginUser['roleId'],true);

            $permissionData = Role::whereIn("id",$role)->get(['permissionIds']);
            $permissionId = [];
            if ($permissionData){
                foreach ($permissionData as $item){
                    array_push($permissionId,json_decode($item['permissionIds'],true));
                }
                $permissionIdList = [];
                if ($permissionId){
                    foreach ($permissionId as $k=>$value){
                        if ($value){
                            foreach ($value as $item) {
                                $permissionIdList[] = $item;
                            }
                        }
                    }
                }
                $route = app(Route::class);
                $action = substr($route->getActionName(),strripos($route->getActionName(),"\\")+1);
                $permissionList = Permissions::whereIn("id",$permissionIdList)->get(['action','group','uri']);
                if (empty($permissionList)&&($action!='ManagerController@logoutHandler'||$action!='HomeController@index')){
                    if (request()->ajax()){
                        return response()->json(['code'=>0,'message'=>'你的账号没有操作权限']);
                    }else{
                        return response()
                            ->view('404', "你的账号没有操作权限", 200)
                            ->header('Content-Type', "text/html");
                    }
                }

                $permissionListName = [];
                $permissionListUri = [];
                foreach ($permissionList as $item){
                    $temp = explode(",",$item['action']);
                    if (!empty($item['uri'])){
                        $permissionListUri[$item['group']][] = $item['uri'];
                    }

                    foreach ($temp as $v) {
                        $permissionListName[] = $v;
                    }
                }
                $permissionListName[] = "ManagerController@logoutHandler";
                $permissionListName[] = "HomeController@index";
                session(['permission'=>$permissionListUri]);
                if (!in_array($action,$permissionListName)){
                    if (request()->ajax()){
                        return response()->json(['code'=>0,'message'=>'你的账号没有操作权限']);
                    }else{
                        return response()
                            ->view('404', "你的账号没有操作权限", 200)
                            ->header('Content-Type', "text/html");
                    }

                }

            }
        }else{
            return redirect("/admin/login");
        }

        return $next($request);
    }
}
