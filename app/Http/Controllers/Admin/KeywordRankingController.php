<?php

namespace App\Http\Controllers\Admin;

use App\ArticleTag;
use App\Http\Requests\Admin\StoreArticleTagPost;
use App\KeyWordRanking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KeywordRankingController extends Controller
{
    function index()
    {
        return view("admin.keyword.index");
    }

    function keywords(Request $request)
    {
        $keyword       = isset($request->keyword)?$request->keyword:0;
        $startDate     = isset($request->startDate)?$request->startDate:0;
        $endDate       = isset($request->endDate)?$request->endDate:0;
        $start = $request->start;
        $length = $request->length;
        $page = (($start+1)*$length);
        $whereCondition = "";
        if ($keyword){
            $whereCondition = "keyword LIKE '%{$keyword}%' AND ";
        }
        if ($startDate&&$endDate){
            $whereCondition.= "date_format(created_at,'%Y-%m-%d') BETWEEN {$startDate} AND $endDate AND ";
        }
        if ($startDate&&!$endDate){
            $whereCondition.= "date_format(created_at,'%Y-%m-%d') > {$startDate} AND ";
        }else if (!$startDate&&$endDate){
            $whereCondition.= "date_format(created_at,'%Y-%m-%d') < {$endDate} AND ";
        }
        if ($whereCondition){
            $sql = "SELECT keyword,count(keyword) as ranking FROM users_search WHERE ".substr($whereCondition,0,-4)." LIMIT $page,$length";
            $totalSql = "SELECT COUNT(id) as page FROM users_serach WHERE ".substr($whereCondition,0,-4);
        }else{
            $sql = "SELECT keyword,count(keyword) as ranking FROM users_search LIMIT $page,$length";
            $totalSql = "SELECT COUNT(id) as page FROM users_serach";
        }

        $data = DB::select($sql);
        $count = DB::select($totalSql);
        return response()->json([
            "draw"            => intval($request->draw),
            "recordsTotal"    => intval(DB::table('users_search')->count("id")),
            "recordsFiltered" => intval($count),
            "data"            => $data
        ],200);
    }

}
