<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //自定义用户登录字段
    public function username()
    {
        //这里这里填写数据库用来登录的字段可以设置如id等后再login页面要设置这个登录字段
        return config('admin.globals.username');
    }
    //验证码重写AuthenticatesUsers类里面的这个validateLogin方法，增加验证码判断
    protected function validateLogin(Request $request)
    {
        //        如果有后台权限就登录到后台没有就登录到前台
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            //captcha是扩展验证码里面的他自定义的验证验证码的验证规则
            'captcha' => 'required|captcha'
        ],[
            //定义验证码的语言required为空captcha填写错误
            'captcha.required' => trans('validation.required'),
            'captcha.captcha' => trans('validation.captcha'),
        ]);
    }
    /*重写退出方法*/
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        //退出登录后返回后台登录页面
        return redirect('login');
    }
    /*第三方登录登录*/
    //获取登录页面
    public function getSocialRedirect($account) {
        try {
            return \Socialite::with($account)->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect('/login');
        }
        // return \Socialite::with('weibo')->scopes(array('email'))->redirect();
    }
    //获取登录用户信息
    public function getSocialCallback($account){
        $socialUser = \Socialite::with($account)->user();
        // 在本地 users 表中查询该用户来判断是否已存在
        $user = User::where('provider_id', $socialUser->id)
            ->where('provider', $account)
            ->first();
        if ($user == null) {
            $socialUser->provider=$account;
            return view("auth/correlation")->with(compact('socialUser','socialUser'));
            /*    // 如果该用户不存在则将其保存到 users 表
                $newUser = new User();
                $newUser->name = $socialUser->getNickname();
                $newUser->username = $socialUser->getId() . mt_rand(0, 999);
                $newUser->email = $socialUser->getEmail() == '' ? '' : $socialUser->getEmail();
                $newUser->password = '';
                $newUser->provider = $account;
                $newUser->provider_id = $socialUser->getId();
                $newUser->save();
                //关联用户数据
                $newUser->getUserData()->save(new User_Data(['user_id' => $newUser->id, 'nickname' => $socialUser->getNickname(), 'headimg' => $socialUser->getAvatar()]));
                $user = $newUser;*/
        }
        // 手动登录该用户
        Auth::login($user);
      /*  // 登录成功后将用户重定向到首页
        //判断登录用户是否有后台权限没有权限就退出登录
        if (Auth::user()->can(config('admin.permissions.system.login'))) {
            return redirect(url('/admin/home'));
        } else {
            // 用户已经登录了...
            Auth::logout();//不是管理员就退出登录
            abort(500, trans('admin/errors.permissions'));
        }*/
    }
}
