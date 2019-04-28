<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreManagerPost;
use App\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $draw        = $request->query->get('draw');
        $orderColumn = $request->query->get('order')['0']['column'];
        $orderDir    = $request->query->get('order')['0']['dir'];
        $fields      = $request->query->get('columns');
        $fieldName   = [];
        foreach ($fields as $key=>$item) {
            $fieldName[$key] = $item['name'];
        }
        $orderSql = "";
        if (isset($orderColumn)) {
            $orderSql = " {$fieldName[intval($orderColumn)]} " . $orderDir;
        }

        $searchItem['account']   = $request->query->get('account');
        $searchItem['loginIp']   = $request->query->get('loginIp');
        $searchItem['loginTime'] = $request->query->get('loginTime');

        $start  = $request->query->get('start');//从多少开始
        $length = $request->query->get('length');//数据长度

        $recordsTotal = $manager->count("mid");
        $data         = $manager->where(function ($query) use ($searchItem) {
            if ($searchItem['account']){
                $query->where("account","=",$searchItem['account']);
            }
            if ($searchItem['loginIp']){
                $query->where("loginIp","=",$searchItem['loginIp']);
            }
            if ($searchItem['loginTime']){
                $query->where("loginTime","=",$searchItem['loginTime']);
            }
        })->orderByRaw($orderSql);

        $recordsFiltered = $data->count("mid");
        $infos           = $data->skip($start)->take($length)->get();
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => $infos->toArray()
        ],200);
    }

    /**
     * 管理员编辑页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function editManager()
    {
        isset(request()->mid)?$data=Manager::where("mid","=",request()->mid)->first():$data='';
        return view("admin.manager.edit",compact('data'));
    }

    /**
     * 管理员编辑
     * @param StoreManagerPost $request
     */
    function storeManager(StoreManagerPost $request)
    {
        print_r($request->all());
    }

    function removeManager(Manager $manager)
    {
        print_r($manager->toArray());
    }
}
