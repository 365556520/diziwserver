<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * 菜单认证
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
        $rule = [
            'parent_id' => 'required',
            'url' => 'required',
            'slug' => 'required',
            'sort' => 'integer',
        ];
        //解决修改菜单栏重复名字提示
        if (request('id','')) {
            $rule['name'] = 'required|unique:menus,name,'.$this->id;
        }else{
            $rule['name'] = 'required|unique:menus,name';
        }
        return $rule;
    }
    public function messages(){
        return [
            'name.required' => '菜单名称不能为空',
            'name.unique'  => '菜单名称已存在',
            'parent_id.required' => '菜单层级不能为空',
            'url.required' => '菜单url不能为空',
            'slug.required' => '菜单权限不能为空',
            'sort.integer' => '排序必须为整数'
        ];
    }
}
