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

    function test()
    {
        return view("admin.articles.test");
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
            if (isset($item->tag->name)) {
                $item->tagName = $item->tag->name;
            }else{
                $item->tagName = "";
            }
            if ($item->userType==2){
                $item->userId      = "平台发布";
                $item->userIdMsg = 0;
            }else{
                $item->userIdMsg = $item['userId'];
                $item->userId      = User::where("userId","=",$item['userId'])->value("realName")?User::where("userId","=",$item['userId'])->value("realName"):User::where("userId","=",$item['userId'])->value("name");
            }

            $item->isShowFlag      = $item->isShow ;
            $item->isShow      = $item->isShow == 0 ? '是' : '否';

            $item->canSharedFlag   = $item->canShared;
            $item->canShared   = $item->canShared == 1 ? '是' : '否';
            $item->isStoraged  = $item->isStoraged == 1 ? '是' : '否';

            if (empty($item->expire)){
                $item->expire = "";
            }else{
                //已置顶且未过期
                if ($item->top==1&&time()<($item->topStartTime+($item->expire*3600))){
                    $item->expire = $item->expire."[未过期]";
                }else if ($item->top==1&&time()>($item->topStartTime+($item->expire*3600))){
                    //已置顶且过期
                    Articles::where("articleId","=",$item->articleId)->update(['top'=>0,'topStartTime'=>0,'expire'=>0,'topNumber'=>0]);
                    $item->expire = "[过期]";
                }

            }
            //是否置顶
            $item->top  = $item->top == 1 ? '是' : '否';

            //置顶开始时间
            if ($item->topStartTime){
                $item->topStartTime = date("Y-m-d H", $item->topStartTime);
            }else{
                $item->topStartTime = "";
            }
            if (empty($item->topNumber)){
                $item->topNumber = 0;
            }
            $item->createdDate = date("Y-m-d H", strtotime($item->created_at));
        }]);
    }

    function edit()
    {
        isset(request()->articleId)?$data=Articles::where("articleId","=",request()->articleId)->first():$data='';
        $tag = ArticleTag::all();
        if ($data){
           //$data['content'] = $this->getCosFileFromArticle($data,'img')->getHtml();
           //$data['content'] = $this->getCosFileFromArticle($data,'embed')->getHtml();
        }
        return view("admin.articles.edit",compact('data','tag'));
    }

    /**
     * 从文章的uriKey下载文件并保存在html
     * @param $article
     * @return QueryList
     */
    private function getCosFileFromArticle($article,$tag)
    {
        $articleHtml = QueryList::getInstance()->html($article->content);
        $articleHtml->find($tag)->map(function($img)use($articleHtml,$article){
            $src = $img->src;
            if ($src) {
                if ($article->userType == 2 && $src) {
                    $pattern = '/other(.*)\?/';//后端图文
                    preg_match_all($pattern, $src, $match);
                    if (isset($match[1][0])&&!empty($match[1][0])){
                        $cosFile = $this->downloadCosFile(
                            [
                                'fileKeyName' => "other" . $match[1][0],
                                'expire'      => config('cos')['expire']
                            ]
                        );
                        if ($cosFile['code']) {
                            $html = $articleHtml->getHtml();
                            $html = str_replace($src, $cosFile['data'], $html);
                            $articleHtml->setHtml($html);
                        }
                    }

                } else {
                    $cosFile = $this->downloadCosFile(//前端图文
                        [
                            'fileKeyName' => $src,
                            'expire'      => config('cos')['expire']
                        ]
                    );
                    if ($cosFile['code']) {
                        $html = $articleHtml->getHtml();
                        $html = str_replace($src, $cosFile['data'], $html);
                        $articleHtml->setHtml($html);
                    }
                }
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
        return empty($request->articleId)?(Articles::create(array_merge($request->except("_token","s"),['isShared'=>1,'userId'=>1,'userType'=>2,'isShared'=>1,'sharedLocation'=>'12','isShow'=>1]))?['code'=>1,'message'=>'文章添加成功']:['code'=>0,'message'=>'文章添加失败']):
            (Articles::where("articleId","=",$request->articleId)->update(array_merge($request->except("_token","s"),['userId'=>1]))?['code'=>1,'message'=>'文章更新成功']:['code'=>0,'message'=>'文章更新失败']);
    }

    function send(Request $request)
    {
        if (empty($request['content']))return ['code'=>0,'message'=>'请填写消息内容'];
        $result = $this->getApi("POST","api/im/sendMsg",request()->except(['s','_token']));
        return ['code'=>1,'message'=>$result];
    }

    function remove(Articles $articles)
    {
        $articles->id = $articles->articleId;
//        if(($checkIfCan=$this->isManager($articles))&&$checkIfCan['code']==0){
//            return $checkIfCan;
//        }
        $articleHtml = $articles->where("articleId","=",$articles->articleId)->value("content");
        $cosKeyNames = $articles->where("articleId","=",$articles->articleId)->value("image");
        if($articles->delete()){
            foreach(explode(",",$cosKeyNames) as $item){
                $this->removeCosFile(['key'=>$item]);
            }
            event(new removeArticle($articleHtml));
            return ['code'=>1,'message'=>'删除成功'];
        }else{return ['code'=>0,'message'=>'删除失败'];}
    }

    function shieldOrShare(Articles $articles)
    {
        return $this->modelShieldOrShare($articles);
    }


}
