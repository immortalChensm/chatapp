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
                $permissionList = Permissions::whereIn("id",$permissionIdList)->get(['action']);
                if (empty($permissionList)&&($action!='ManagerController@logoutHandler'||$action!='HomeController@index'))return response()->json(['code'=>0,'message'=>'你的账号没有操作权限2']);

                $permissionListName = [];
                foreach ($permissionList as $item){
                    $temp = explode(",",$item);
                    foreach ($temp as $v) {
                        $permissionListName[] = $v;
                    }
                }
                if (!in_array($action,$permissionListName)){
                    return response()->json(['code'=>0,'message'=>'你的账号没有操作权限1']);
                }

            }
        }else{
            return redirect("/admin/login");
        }

        return $next($request);
    }
}
