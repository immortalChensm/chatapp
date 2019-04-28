<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleTagPost extends FormRequest
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
        if (!empty($this['tagId'])){
            return [
                'name'=>[
                    'required',
                    Rule::unique("article_tag")->ignore($this->get("tagId"),"tagId"),
                ]
            ];
        }else{
            return [
                'name'=>'required|unique:article_tag,name',
            ];
        }
    }

    public function messages()
    {
        return $message = [
            'name.required'=>'请填写标签名称',
            'name.unique'=>'标签已存在',
        ];
    }
}
