<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploaderController extends Controller
{
    function uploadFile()
    {
        return response()->json($this->upload());
    }

    function removeFile()
    {
        if ($this->removeCosFile(['key'=>request()->fileKeyName])['code']==1){
            return response()->json(['code'=>1,'message'=>'移除成功']);
        }

    }
}
