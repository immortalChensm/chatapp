<?php

namespace App\Http\Controllers\Admin;

use App\ArticleTag;
use App\Http\Requests\Admin\StoreArticleTagPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{

    function index()
    {
        return view("admin.role.index");
    }

    function roles(Request $request,ArticleTag $articleTag)
    {
        return $this->models(...[$request,$articleTag,function (&$searchItem)use($request){
            $searchItem['name']   = $request->query->get('name');
        },function ($query,&$searchItem){
            if ($searchItem['name']){
                $query->where("name","LIKE","%".$searchItem['name']."%");
            }
        }]);
    }
    /**
     * 标签编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit()
    {
        isset(request()->tagId)?$data=ArticleTag::where("tagId","=",request()->tagId)->first():$data='';
        return view("admin.articletag.edit",compact('data'));
    }

    function store(StoreArticleTagPost $request)
    {
        return empty($request->tagId)?(ArticleTag::create($request->except("_token","s"))?['code'=>1,'message'=>'添加成功']:['code'=>0,'message'=>'添加失败']):
            (ArticleTag::where("tagId","=",$request->tagId)->update(['name'=>$request->name])?['code'=>1,'message'=>'更新成功']:['code'=>0,'message'=>'更新失败']);
    }

    function remove(ArticleTag $articleTag)
    {
        return $this->removeModel($articleTag);
    }
}
