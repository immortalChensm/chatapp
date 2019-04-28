<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMusicPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'title'=>'required|unique:musics,title',
            'singer'=>'required',
            'introduction'=>'required',
            'uriKey'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'请填写音乐名称',
            'singer.required'=>'请填写歌手',
            'title.unique'=>'该音乐已存在',
            'introduction.required'=>'请填写音乐简介',
            'uriKey.required'=>'请上传一首音乐'
        ];
    }
}
