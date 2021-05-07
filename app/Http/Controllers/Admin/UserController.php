<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\AminModels\model_has_roles;
use App\Repositories\Eloquent\Admin\Rabc\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends CommonController
{
    private $user;
    function __construct(UserRepository $user)
    {        //调用父累的构造方法
        parent::__construct('user');
        //user
        $this->user = $user;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.list');
    }
//权限表DataTables
    public function ajaxIndex(Request $request){
        $result = $this->user->ajaxIndex($request->all());
        return $result;
    }
    /**
     * 添加用户界面
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

    }

    /**
     * 添加用户逻辑
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        //获取这个账号信息
        $user = $this->user->getUser($id);
        foreach ($user->role as $k =>$v){
            /*获取所有角色权限的数据*/
            $user->role[$k] = $this->role->getRole($v->id);
        }
        return view('admin.user.show')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $roles = Role::all(); //所有角色
        //获取用户目前有的角色
        $hasroles = model_has_roles::select('role_id')->where('model_id',$id)->get();//已经拥有的角色id
        return view('admin.user.edit')->with(compact('roles','hasroles','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     **/
    public function update(Request $request, $id){
        $user = User::where('id',$id)->first();
        $role = false;
        if(isset($request->all()['check'])){
//            dd($request->all()['check']);
             $role = $user->syncRoles($request->all()['check']);
        }
        if ($role) {
            flash("角色授权成功",'success');
        } else {
            flash("角色授权失败", 'error');
        }
        return redirect(url()->previous());
    }

    /**
     * 删除角色
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $this->user->destroyUser($id);
        return redirect(url('admin/user'));
    }
}
