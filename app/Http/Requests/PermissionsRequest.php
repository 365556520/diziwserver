<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionsRequest extends FormRequest
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
        $rules = [];
        if (request('id','')) {
            $rules['name'] = 'required|unique:permissions,name,'.$this->id;
        }else{
            $rules['name'] = 'required|unique:permissions,name';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '权限不能为空',
            'name.unique' => '权限不能重复',
        ];
    }
}
