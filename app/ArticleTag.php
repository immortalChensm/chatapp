<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    //
    protected $table = "article_tag";
    public $primaryKey = "tagId";
    protected $guarded = [];
}
