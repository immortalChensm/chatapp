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
        if (session()->exists("loginUser")){
            return redirect("/admin");
        }else{
            return view("admin.manager.login");
        }

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
                    //登录成功后，获取该客服账号的好友列表【专业版限制为3000个好友】
                   // $customer = $this->getApi('POST','api/im/kefu/login',[]);
                   // $friends = $this->getApi('POST','api/user/friends/admin',[]);
                   // session(['imToken'=>$customer['result']]);
                   // session(['imFriends'=>$friends['result']['data']]);
                    return ['code'=>1,'message'=>'登录成功'];
                }else{
                    return ['code'=>0,'message'=>'登录密码填写错误'];
                }
            }else{
                return ['code'=>0,'message'=>'登录账号填写错误'];
            }
        }
    }

    function logoutHandler()
    {
        if (session()->exists("loginUser")){
            session()->flush();
            //return view("admin.manager.login");
            return redirect("/admin/login");
        }else{
            return redirect("/admin/login");
        }
    }

    function removeManager(Manager $manager)
    {
        return $this->removeModel($manager);
    }

    function top()
    {
        $tables = [1=>'articles',2=>'musics',3=>'photos',4=>'videos'];
        $fields = [1=>'articleId',2=>'musicId',3=>'photoId',4=>'videoId'];
        $top = DB::table($tables[request("topType")])->where($fields[request("topType")],"=",request("topId"))->first();
        //这内容已经置顶且未过期
        if ($top['top']==1&&time()<($top['topStartTime']+($top['expire']*3600))){
            DB::table($tables[request("topType")])->where($fields[request("topType")],"=",request("topId"))->update([
                "top"=>0,
                'expire'=>0,
                'number'=>0
            ]);
        }else{
            //内容不存在|也需要验证置顶编号
            $number = DB::table("apmv")->where("topNumber",request("number"))->value("topNumber");
            if (empty($number)){
                DB::table($tables[request("topType")])->where($fields[request("topType")],"=",request("topId"))->update([
                    'top'=>1,
                    "topStartTime"=>time(),
                    "expire"=>request("expire"),
                    'number'=>request("number")
                ]);
            }else{
                return ['code'=>0,'message'=>'置顶编号不可重复'];
            }

        }
        return ['code'=>1,'message'=>'置顶成功'];
    }
}
