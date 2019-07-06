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

class TestController extends Controller
{


    function index()
    {
        echo microtime(true);
        //sleep(10);
        echo microtime(true);
    

        return 123;
    }

    function test()
    {
        return 456;
    }
}
