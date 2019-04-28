<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticlePost extends FormRequest
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
            //
            'tagId'=>'required',
            'title'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'请填写文章标题',
            'tagId.required'=>'请选择一个文章标签'
        ];
    }
}
