<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
class UserRequest extends FormRequest
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
     * 自定义验证规则
     *
     * @return void
     */
    public function addValidator()
    {   //验证用户原密码
        Validator::extend('check_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value,Auth::user()->password);
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    public function rules(){
        $this->addValidator();
        $rules = [
            //sometimes的意思数据中有改字段了才会验证 没有就不会验证
            'name' => 'sometimes|required|string|max:255',
            //这里是添加自定义字段规则
            'password' => 'sometimes|required|string|min:6|confirmed',
            /*修改密码*/
            //原始密码
            'original_password' => 'sometimes|required|check_password',
            //确认新密码
            'password_confirmation' => 'sometimes|required',
        ];
        if (request('id','')) {
            //注意验证唯一unique:roles,name,中unique:后面的表名必须和数据库中的表名一样
            $rules['username'] = 'sometimes|required|unique:users,username,'.$this->id;
            $rules['email'] = 'sometimes|required|string|email|max:255|unique:users,email'.$this->id;
        }else{
            $rules['username'] = 'sometimes|required|unique:users,username';
            $rules['email'] = 'sometimes|required|unique:users,email';
        }
        return $rules;
    }

    public function messages()
    {
        return [
        'required'  => trans('validation.required'),
        'unique'    => trans('validation.unique'),
        'numeric'   => trans('validation.numeric'),
        'email'     => trans('validation.email'),
        'check_password'     => '旧密码不正确',
        ];
    }
/**
 * 字段名称
 * @author 晚黎
 * @date   2016-11-03T14:52:38+0800
 * @return [type]                   [description]
 */
public function attributes()
{
    return [
        'id'        => trans('admin/user.model.id'),
        'name'      => trans('admin/user.model.name'),
        'username'  => trans('admin/user.model.username'),
        'email'     => trans('admin/user.model.email'),

        'original_password' => '原始密码',
        'password_confirmation' => '确认密码',
    ];
}
}
