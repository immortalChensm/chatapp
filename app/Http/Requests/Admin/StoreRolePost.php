<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRolePost extends FormRequest
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
        if (!empty($this['id'])){
            return [
                'name'=>[
                    'required',
                    Rule::unique("roles")->ignore($this->get("id"),"id"),
                ],
                'description'=>[
                    'required'
                ],
            ];
        }else{
            return [
                'name'=>'required|unique:roles,name',
                'description'=>[
                    'required'
                ],
            ];
        }
    }

    public function messages()
    {
        return $message = [
            'name.required'=>'请填写角色名称',
            'name.unique'=>'角色已存在',
            'description.required'=>'请填写角色说明',
        ];
    }
}
