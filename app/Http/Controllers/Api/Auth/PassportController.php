<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\UserFacade;
use App\Http\Controllers\Api\CommonController;
use App\Models\Role;
use App\Models\UsersModel\User_Data;
use App\User;
use http\Client;
use Validator;
use Illuminate\Http\Request;
use Auth;
use \Illuminate\Auth\Passwords\PasswordBroker;
use GuzzleHttp\Exception\RequestException;
use Spatie\Permission\Models\Permission;

class PassportController extends CommonController
{
    public $successStatus = 200;  //信息状态码
    public function __construct()
    {
        $this->content = array();
    }
    //登录
    public function login(){
        //判断用户存在不
       // $dome = new \App\Repositories\Eloquent\UserFacadeRepository;
        $this->content =  UserFacade::userLogin(request('username'),request('password'));
        if($this->content['code'] == 200)
        {
            $this->successStatus = 200;
        } else {
            $this->successStatus = 401;
        }
        return response()->json($this->content, $this->successStatus);
    }
    /**
     * 注册Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {   //验证注册数据
        $validator = Validator::make($request->all(), [
            'name' =>'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' =>'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        //验证失败返回失败信息
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'code'=>401]);
        }
        //验证成功
        $input = $request->all();
        $pasd = $input['password'];
        $input['password'] = bcrypt($input['password']); //密码加密后存储
        $user = User::create($input); //在数据库中创建该用户
        if($user){
            //判断用户存在不
            $this->content =  UserFacade::userLogin($input['username'],$pasd);
            if($this->content['code']== 200)
            {
                //默认添加普通用户的权限
                $userRole = Role::where('name','user')->first();
                $user = Auth::user();
                $user->roles()->attach($userRole->id);
                //关联用户数据
                $user->getUserData()->save(new User_Data(['user_id' => $user->id]));
                $this->successStatus = 200;
            } else {
                $this->successStatus = 401;
            }
        }
        return response()->json(['data'=>$this->content,'code'=> $this->successStatus]);
    }

    //返回用户信息
    public function passport()
    {
        $userdata = User::select('id','name','headimg')->where('id',Auth::user()->id)->with('getUserData')->get();
        $userdata['parmission'] = UserFacade::getUserAllPermission(); //当前登录用户所有的权限
        return response()->json(['user' => $userdata],$this->successStatus);
    }

    /**
     * 退出登录 删除用户令牌
     */
    public function logout()
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }
        return response()->json(['message' => '登出成功', 'status_code' =>  $this->successStatus, 'data' => null]);
    }
    /*
     * 判断邮箱或者用户是否存在
     * */
    public function isUser(Request $request){
        $data = $request->all();
        $mes = '';
        if (UserFacade::isUser($data['lname'],$data['data'])){
            $mes = '存在';
        }else{
            $mes = '数据不存在';
            $this->successStatus = 401;
        }
        return response()->json(['message' => $mes,'code'=>$this->successStatus]);
    }
    //发送重置密码邮件
    public function resetEmail(Request $request){
        $user = User::where('email', $request->email)->first();
        //实例化一个PasswordBroker类
        //发邮件实际使用的是sendResetLink函数，该函数就在PasswordBroker里
        $password_broker = app(PasswordBroker::class);
        //生成token
        $token = $password_broker->createToken($user);
        //调用User模型中的sendPasswordResetNotification方法发送邮件
        $user->sendPasswordResetNotification($token);
        return response()->json(['message' => '邮件发送成功','code'=>$this->successStatus]);
    }

    //第三方登录
    public function socialLogin(Request $request){
         //判断用户存在不
        $this->content =  UserFacade::socialLogin(request('provider_id'),request('provider'));
        if($this->content['code'] == 200)
        {
            $this->successStatus = 200;
        } else {
            $this->successStatus = 401;
        }
        return response()->json($this->content, $this->successStatus);
    }
    //第三方用户关联
    public function correlation(Request $request){
        //判断用户存在不
        $this->content =  UserFacade::correlation(request('username'),request('password'),json_decode(request('correlationData')));
        if($this->content['code'] == 200)
        {
            $this->successStatus = 200;
        } else {
            $this->successStatus = 401;
        }
        return response()->json($this->content, $this->successStatus);
    }
    //获取获取大一平台登录key一次只能用30分钟
    public function  getDayiKey(){
        $date = '';
        //判读当前用户的权限
        $pass = '';
        //判断账号属于村村通还是客运  目的是根据权限获取账号信息
        if (Auth::user()->hasPermissionTo('cuncuntong')) {
            $pass = Permission::where('name','xxfhgj')->first();
        }else if (Auth::user()->hasPermissionTo('keyun')){
            $pass = Permission::where('name','nyswxxjad')->first();
        }
        //判断是否有权限
        if ($pass!=''){
            $url = "http://123.162.189.21/gps-web/api/login.jsp?password=".$pass->guard_name."&userId=".$pass->name."&loginType=user&loginWay=interface&loginLang=zh_CN";
            $client = new \GuzzleHttp\Client();
            try {
                $res =  $client->request('POST',$url);
                $date = json_decode($res->getBody()->getContents());//把获取的json数据转换成数组
                $date->usersid = $pass->name; //返回账号名字
                $this->successStatus = 200;
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $this->date =  $e->getResponse();
                    $this->successStatus = 401;
                }
            }
        }else{
            $this->successStatus = 300;
            $date = '权限不够';
        }
        return response()->json(['data' => $date,'code'=>$this->successStatus]);
    }
}
