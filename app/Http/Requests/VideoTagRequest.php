<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class VideoTagRequest extends FormRequest
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



    public function rules(){
        if (request('id','')) {
            $rules['name'] = 'sometimes|required|max:15|unique:videotags,name,'.$this->id;
        }else{
            $rules['name'] = 'sometimes|required|max:15|unique:videotags,name';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '视频标签不能为空',
            'name.unique' => '视频标签已经存在',
        ];
    }
}
