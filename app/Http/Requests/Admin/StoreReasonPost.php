<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReasonPost extends FormRequest
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
                'reason'=>[
                    'required',
                    Rule::unique("report_reasons")->ignore($this->get("id"),"id"),
                ]
            ];
        }else{
            return [
                'reason'=>'required|unique:report_reasons,reason',
            ];
        }
    }

    public function messages()
    {
        return $message = [
            'reason.required'=>'请填写名称',
            'reason.unique'=>'名称已存在',
        ];
    }
}
