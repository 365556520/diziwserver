<?php
namespace App\Repositories\Eloquent;
/**
 * 门面模式
 * User: admin
 * Date: 2018/1/14
 * Time: 9:43
 */
use App\Models\Role;
use App\Models\UsersModel\User_Data;
use App\User;
use App\Repositories\Contracts\UserInterface;
use Illuminate\Support\Facades\Auth;
class UserFacadeRepository implements UserInterface {
    /*根据用户id查找用户信息
    */
    public function findBy($id){
        return User::find($id);
    }
    /*
     * 用户名认证并签发token
     * */
    public function userLogin($username,$password){
        $content = array();
        //判断用户存在不
        if(Auth::attempt(['username' => $username, 'password' =>$password]))
        {
            $user = Auth::user();
            $content['token'] =  $user->createToken('Pi App')->accessToken; //创建令牌
            $content['message'] =  '登录成功';
            $content['code'] = 200;
        } else {
            $content['error'] = "未授权";
            $content['code'] = 401;
        }
        return $content;
    }
    /*api第三方登录*/
    public function socialLogin($provider_id,$provider){
        $content = array();
        $user = User::where('app_provider_id', $provider_id)
            ->where('provider', $provider)
            ->first();
        if ($user == null){ //不存在
            $content['message'] =  '数据不存在';
            $content['code'] = 401;
        }else{
            Auth::login($user); //如果存在就手动登录然后签发令牌
            $user = Auth::user();
            $content['token'] =  $user->createToken('Pi App')->accessToken; //创建令牌
            $content['message'] =  '登录成功';
            $content['code'] = 200;
        };
        return $content;
    }
    /*
     * api管理第三方用户
     * $username  $password账号密码
     * $correlationData 关联信息
    */
    public function correlation($username,$password,$correlationData){
        $content = array();
        //判断用户存在不
        if(Auth::attempt(['username' => $username, 'password' =>$password]))
        {
            $user = Auth::user();
            //绑定用户
            User::where('id',$user->id)->update(['app_provider_id' => $correlationData->provider_id,'provider' => $correlationData->provider]);
            if(User_Data::where('user_id',$user->id)->first()==null){
                $user->getUserData()->save(new User_Data(['user_id' => $user->id,'headimg'=>$correlationData->avatarUrl])); //添加图片
            }
            $content['token'] =  $user->createToken('Pi App')->accessToken; //创建令牌
            $content['message'] =  '登录成功';
            $content['code'] = 200;
        } else {
            $content['error'] = "未授权";
            $content['code'] = 401;
        }
        return $content;
    }
    /*
     * 判断用户是否存在
     * */
    public function isUser($lname,$data){
       return User::where($lname, $data)->exists();
    }
}