<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $rules = [
            'display_name' => 'required',
        ];
        if (request('id','')) {
            //注意验证唯一unique:roles,name,中unique:后面的表名必须和数据库中的表名一样
            $rules['name'] = 'required|unique:roles,name,'.$this->id;
        }else{
            $rules['name'] = 'required|unique:roles,name';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '权限不能为空',
            'name.unique' => '权限不能重复',
            'display_name.required' => '权限名称不能为空',
        ];
    }
}
