<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreManagerPost extends FormRequest
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
        if (!empty($this['mid'])){
            return [
                'account'=>[
                    Rule::unique("managers")->ignore($this->get("mid"),"mid"),
                ],
                'roleId'=>'required',
                'password'=>'nullable|min:6|max:30|confirmed',
            ];
        }else{
            return [
                'account'=>'required|unique:managers',
                'roleId'=>'required',
                'password'=>'required|min:6|max:30|confirmed',
            ];
        }

    }

    public function messages()
    {
        $message = [
            'account.unique'=>'账号已存在',
            'roleId.required'=>'请选择一个角色',
            'password.min'=>'密码位数不得少于6位',
            'password.max'=>'密码位数不得超过30位',
            'password.confirmed'=>'密码与确认密码不一致',
        ];
        if (!empty($this['mid'])){
            return $message;
        }else{
            return array_merge($message,[
                'account.required'=>'账号不可为空',
                'password.required'=>'请设置一个密码',
            ]);
        }

    }
}
