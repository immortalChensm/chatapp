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
//        $photo = Photos::where("photoId","=",$request->photoId)->first();
//        if ($photo->userType==1){
//            return response()->json(['code'=>0,'message'=>'用户发布的相册禁止修改！']);
//        }
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

                $permissionList = Permissions::whereIn("id",$permissionIdList)->get(['action']);
            }
        }else{
            //return response()->json(['code'=>0,'message'=>'用户发布的相册禁止修改！']);
            return redirect("/admin/login");
        }



//        print_r($permissionIdList);
//        print_r($permissionList->toArray());
        /** @var Route $route */
        $route = app(Route::class);
        if(substr($route->getActionName(),strripos($route->getActionName(),"\\")+1)){

        }else{

        }
        //print_r(session("loginUser"));
        return $next($request);
    }
}
