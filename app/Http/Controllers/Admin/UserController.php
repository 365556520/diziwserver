<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Repositories\Eloquent\Admin\Rabc\UserRepository;
use Illuminate\Http\Request;


class UserController extends CommonController
{
    private $user;
    function __construct(UserRepository $user)
    {
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

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
