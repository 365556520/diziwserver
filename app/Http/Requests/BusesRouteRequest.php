<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class BusesRouteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *线路认证规则
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    public function rules(){
        $rules = [
            'buses_start' => 'required',
            'buses_end' => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'buses_start.required' => '始点不能为空',
            'buses_end.required' => '终点不能为空',
        ];
    }
}
