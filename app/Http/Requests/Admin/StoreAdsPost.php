<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdsPost extends FormRequest
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

            'name'=>'required',
            'company'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'mobile'=>[
                'required',
                'regex:/^1[34578]\d{9}$/',
            ],
            'content'=>'required',
            'type'=>'required',
            'uri'=>'required',
        ];
    }

    public function messages()
    {
       return [
           'name.required'=>'请填写广告名称',
           'company.required'=>'请填写公司名称',
           'address.required'=>'请填写公司地址',
           'contact.required'=>'请填写联系人',
           'mobile.required'=>'请填写手机号码',
           'mobile.regex'=>'手机号码不正确',
           'content.required'=>'请填写活动内容',
           'type.required'=>'请选择广告类型',
           'uri.required'=>'请上传文件',
       ];
    }
}
