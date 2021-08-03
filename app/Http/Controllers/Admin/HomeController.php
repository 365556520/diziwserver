<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\HomeRepository;
use App\Repositories\Eloquent\Admin\MenuRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HomeController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $menu;
    private $home;
    public function __construct(MenuRepository $menuRepository,HomeRepository $homeRepository){
        //调用父累的构造方法
        parent::__construct('system.login');
        $this->menu = $menuRepository;
        $this->home = $homeRepository;
    }
    //头像图片渲染
    public function showheadimg(Request $request){
        //防止重复提交
        $request->session()->put('register',time());
        return view('auth.adminData.headimg');
    }
    //头像图片修改
    public function headimg(Request $request){
        if($request->session()->has('register')){
            //存在则表示是首次提交，清空session中的'register'
            $request->session()->forget('register');

        }else{
            //否则抛http异常，跳转到403页面
            flash("不能重复提交",'error');
        }
        $this->home->qiniuUpHeadimg($request->all());
        return view('auth/adminData/headimg');
    }

    /**
     * Show the application dashboard.
     *后台页面
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
    }

    public function show($id){
    }
    /*修改用户资料料界面
     *
     * */
    public function edit(Request $request,$id){
        //防止重复提交
        $request->session()->put('register',time());
        return view('auth.adminData.userdata');
    }

    /**
     *修改用户资料料逻辑
     */
    public function update(Request $request,$id){
        if($request->session()->has('register')){
            //存在则表示是首次提交，清空session中的'register'
            $request->session()->forget('register');
            //        修改信息
            $this->home->updateUser($request->all(),$id);
        }else{
            //否则抛http异常，跳转到403页面
            flash("不能重复提交",'error');
        }
        return view('auth.adminData.userdata');
    }

    /**
     *
     */
    public function destroy($id){

    }
    /*
     * 后台左边菜单列表、
     * */
    public function menus(){
        return ['code' => 200,"token"=>'','msg'=>'成功获取列表','data' => $this->menu->getMenuListJson()];

    }
    //后台主页面
    public function homepage()
    {
        return view('admin/home');
    }
}
