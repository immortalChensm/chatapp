<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoPost extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'title'=>'required|unique:photos,title',
            'introduction'=>'required',
            'uriKey'=>'required'
        ];
    }

    public function messages()
    {
       return [
           'title.required'=>'请填写相册名称',
           'title.unique'=>'相册已存在',
           'introduction.required'=>'请填写相册简介',
           'uriKey.required'=>'请添加一张图片'
       ];
    }
}
