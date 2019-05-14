<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    //
    function index()
    {
        $data = (new Collection(Db::table("system")->get()))->toArray();
        return view("admin.system.index",compact('data'));
    }

    function store()
    {
        $data = request()->except("_token","s");
        foreach($data['config'] as $field=>$value){
            DB::table("system")->where("name","=",$field)->update(['value'=>$value]);
        }
        return ['code'=>1,'message'=>'保存成功'];
    }
}
