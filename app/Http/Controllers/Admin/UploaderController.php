<?php

namespace App\Http\Controllers\Admin;

use App\Cosjs\Qcloud;
use App\Http\Controllers\Controller;
class UploaderController extends Controller
{
    function uploadFile()
    {
        return response()->json($this->upload());
    }

    function removeFile()
    {
        if (isset(request()->file)){
            set_error_handler(function(){});
            if (file_exists(request()->file))
            unlink(request()->file);
            restore_error_handler();
            return response()->json(['code'=>1,'message'=>'移除成功']);
        }else{
            if ($this->removeCosFile(['key'=>request()->fileKeyName])['code']==1){
                return response()->json(['code'=>1,'message'=>'移除成功']);
            }
        }


    }

    /**
     * js临时key
     */
    function jsUploadTempKeys()
    {
        $tempKeys = (new Qcloud())->getTempKeys(config("cos")['jsConfig']);
        return response($tempKeys,200,[
            'Access-Control-Allow-Origin'=>'*',
            'Access-Control-Allow-Headers'=>'Origin, Content-Type, Cookie, Accept',
            'Access-Control-Allow-Methods'=>'GET, POST, PATCH, PUT, OPTIONS',
            'Access-Control-Allow-Credentials'=>'false',
        ]);
    }


}
