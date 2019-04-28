<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    //
    public $primaryKey = "articleId";
    protected $guarded = [];

    public function tag()
    {
        return $this->belongsTo('App\ArticleTag','tagId','tagId')->select("name");
    }
}
