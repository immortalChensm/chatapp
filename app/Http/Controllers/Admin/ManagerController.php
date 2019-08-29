<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreManagerPost;
use App\Manager;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    /**
     * 管理员列表界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        return view("admin.manager.index");
    }

    /**
     * 管理员列表数据
     */
    function managers(Request $request,Manager $manager)
    {
        return $this->models(...[$request,$manager,function (&$searchItem)use($request){
            $searchItem['account']   = $request->query->get('account');

        },function ($query,&$searchItem){
            if ($searchItem['account']){
                $query->where("account","LIKE","%".$searchItem['account']."%");
            }

        },function (&$item){
            $roleName = Role::whereIn("id",json_decode($item['roleId'],true))->get(["name"])->toArray();
            $role = '';
            foreach ($roleName as $itemValue){
                $role.=$itemValue['name'].",";
            }
            $item->role = substr($role,0,-1);
            $item->loginTime = date("Y-m-d H:i:s",$item->loginTime);
        }]);
    }

    /**
     * 管理员编辑页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function editManager()
    {
        isset(request()->userId)?$data=Manager::where("userId","=",request()->userId)->first():$data='';
        $role = Role::all(['id','name']);
        if ($data){
            $data['roleId'] = json_decode($data['roleId'],true);
        }
        return view("admin.manager.edit",compact('data','role'));
    }

    function storeManager(StoreManagerPost $request)
    {
        if (empty($request['roleId'])){
            return ['message'=>'请选择一个角色'];
        }
        $request['roleId'] = json_encode($request['roleId']);

        if(empty($request->userId)) {
            $request['password'] = Hash::make($request['password']);
            return Manager::create($request->except("_token", "s", "password_confirmation")) ? ['code' => 1, 'message' => '添加成功'] : ['code' => 0, 'message' => '添加失败'];

            }else{
            if (empty($request['password'])){
                return Manager::where("userId","=",$request['userId'])->update([
                    'account'=>$request['account'],
                    'roleId'=>$request['roleId'],
                ])?['code'=>1,'message'=>'更新成功']:['code'=>0,'message'=>'更新失败'];
            }else{
                $request['password'] = Hash::make($request['password']);
                return Manager::where("userId","=",$request['userId'])->update([
                    'account'=>$request['account'],
                    'roleId'=>$request['roleId'],
                    'password'=>$request['password'],
                ])?['code'=>1,'message'=>'更新成功']:['code'=>0,'message'=>'更新失败'];
            }

        }
    }

    function login()
    {
        return view("admin.manager.login");
    }

    function loginHandler()
    {
        $account = request("account");
        $password = request("password");
        if (empty($account)||empty($password)){
            return ['code'=>0,'message'=>'请填写登录账号或密码'];
        }else{
            $data = Manager::where("account",$account)->first();
            if ($data){
                if (Hash::check($password,$data['password'])){
                    session(['loginUser'=>$data->toArray()]);
                    Manager::where("userId",$data['userId'])->update(['loginIp'=>request()->getClientIp(),'loginTime'=>time()]);

                    //客服账号登录
                    $customer = $this->getApi('POST','api/im/kefu/login',[]);
                    session(['imToken'=>$customer['result']]);
                    return ['code'=>1,'message'=>'登录成功'];
                }else{
                    return ['code'=>0,'message'=>'登录密码填写错误'];
                }
            }else{
                return ['code'=>0,'message'=>'登录账号填写错误'];
            }
        }
    }

    function removeManager(Manager $manager)
    {
        return $this->removeModel($manager);
    }

    function top()
    {
        $ret = DB::table("top")->where("id","=",1)->value("topId");
        if ($ret){
            DB::table("top")->where("id","=",1)->update([
                'topId'=>request("topId"),
                "topType"=>request("topType"),
                "created_at"=>date("Y-m-d H:i:s")
            ]);
        }else{
            DB::table("top")->insert([
                'topId'=>request("topId"),
                "topType"=>request("topType"),
                "created_at"=>date("Y-m-d H:i:s")
            ]);
        }
        return ['code'=>1,'message'=>'设置成功'];
    }
}
