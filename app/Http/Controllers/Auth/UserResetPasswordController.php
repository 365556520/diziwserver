<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UserResetPasswordController extends Controller{

    //修改密码视图
    public function resetPas(){
        return view('auth.adminData.resretpas');
    }
    //修改密码逻辑
    public function reset(UserRequest $request){
        //得到当前用户模型然后修改密码保存
        $model = \Auth::user();
        $model->password = bcrypt($request['password']);
        if ($model->save()){
//        修改密码成功
            flash('密码修改成功','success');
        }else{
            flash('密码修改失败', 'error');
        }
        return redirect()->back();
    }
    //注册成功页面
    public function success($massage){
        return view('auth.success')->with(compact('massage','massage'));
    }
}
