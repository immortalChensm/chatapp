<?php

namespace App\Http\Controllers\Admin;

use App\Articles;
use App\ArticleTag;
use App\Events\removeArticle;
use App\Http\Requests\Admin\StoreArticlePost;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QL\QueryList;

class ArticlesController extends Controller
{

    /**
     * 文章列表页面
     */
    function index()
    {
        $tag = ArticleTag::all();
        return view("admin.articles.index",compact('tag'));
    }

    function articles(Request $request,Articles $articles)
    {
        return $this->models(...[$request,$articles,function (&$searchItem)use($request){
            $searchItem['title']   = $request->query->get('title');
            $searchItem['tagId']   = $request->query->get('tagId');
        },function ($query,&$searchItem){
            if ($searchItem['title']){

                $query->where("title","LIKE","%".$searchItem['title']."%");
            }
            if ($searchItem['tagId']){
                $query->where("tagId","=",$searchItem['tagId']);

            }
        },function (&$item){
            $item->tagName     = $item->tag->name;
            //$item->userId      = User::where("userId","=",$item['userId'])->value("name");
            $item->isShow      = $item->isShow == 0 ? '是' : '否';
            $item->canShared   = $item->canShared == 1 ? '是' : '否';
            $item->isStoraged  = $item->isStoraged == 1 ? '是' : '否';
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function edit()
    {
        isset(request()->articleId)?$data=Articles::where("articleId","=",request()->articleId)->first():$data='';
        $tag = ArticleTag::all();
        if ($data){
            $data['content'] = $this->getCosFileFromArticle($data)->getHtml();
        }
        return view("admin.articles.edit",compact('data','tag'));
    }

    /**
     * 从文章的uriKey下载文件并保存在html
     * @param $article
     * @return QueryList
     */
    private function getCosFileFromArticle($article)
    {
        $articleHtml = QueryList::getInstance()->html($article->content);
        $articleHtml->find('img')->map(function($img)use($articleHtml){
            $src = $img->src;
            $pattern = '/other(.*)\?/';
            preg_match_all($pattern,$src,$match);
            $cosFile = $this->downloadCosFile(
                    [
                        'fileKeyName'=>"other".$match[1][0],
                        'expire'=>config('cos')['expire']
                    ]
                );
            if ($cosFile['code']){
                $html = $articleHtml->getHtml();
                $html = str_replace($src,$cosFile['data'],$html);
                $articleHtml->setHtml($html);
            }
        });

        return $articleHtml;
    }

    function store(StoreArticlePost $request)
    {
        if (!empty($request->articleId)){
            $article = Articles::where("articleId","=",$request->articleId)->first();
            $article->id = $article->articleId;
            if(($checkIfCan=$this->isManager($article))&&$checkIfCan['code']==0){
                return $checkIfCan;
            }
        }
        return empty($request->articleId)?(Articles::create(array_merge($request->except("_token","s"),['userId'=>1,'userType'=>2]))?['code'=>1,'message'=>'文章添加成功']:['code'=>0,'message'=>'文章添加失败']):
            (Articles::where("articleId","=",$request->articleId)->update(array_merge($request->except("_token","s"),['userId'=>1]))?['code'=>1,'message'=>'文章更新成功']:['code'=>0,'message'=>'文章更新失败']);
    }

    function remove(Articles $articles)
    {
        $articles->id = $articles->articleId;
        if(($checkIfCan=$this->isManager($articles))&&$checkIfCan['code']==0){
            return $checkIfCan;
        }
        $articleHtml = $articles->where("articleId","=",$articles->articleId)->value("content");
        if($articles->delete()){
            event(new removeArticle($articleHtml));
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }

    /**
     * 文章的屏蔽或分享限制操作
     */
    function shieldOrShare(Articles $articles)
    {
        return $this->modelShieldOrShare($articles);
    }


}
