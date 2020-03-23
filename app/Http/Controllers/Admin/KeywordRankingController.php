<?php

namespace App\Http\Controllers\Admin;

use App\ArticleTag;
use App\Http\Requests\Admin\StoreArticleTagPost;
use App\KeyWordRanking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeywordRankingController extends Controller
{
    function index()
    {
        return view("admin.keyword.index");
    }

    function keywords(Request $request,KeyWordRanking $keyWordRanking)
    {
        return $this->models(...[$request,$keyWordRanking,function (&$searchItem)use($request){
            $searchItem['keyword']   = $request->query->get('keyword');
            $searchItem['startTime']   = $request->query->get('startTime');
            $searchItem['endTime']   = $request->query->get('endTime');
        },function ($query,&$searchItem){
            if ($searchItem['keyword']){
                $query->where("keyword","LIKE","%".$searchItem['keyword']."%");
            }
            if ($searchItem['startTime']&&$searchItem['endTime']){
                $query->whereBetween("created_at",[$searchItem['startTime'],$searchItem['endTime']]);
            }
        }]);
    }

}
