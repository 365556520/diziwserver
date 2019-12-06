<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
// 引入 laravel-permission 模型
use App\Repositories\Eloquent\Admin\Rabc\RolesRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class RolesController extends CommonController
{
   private $role;
    function __construct(RolesRepository $role){
        //role
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.list');
    }
//权限表DataTables
    public function ajaxIndex(Request $request){
        $roles =  $this->role->ajaxIndex($request->all());// 获取角色分页
        return $roles;
    }

    /**
     * 添加视图
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.add');
    }

    /**
     * 添加表单逻辑
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request){
        $roles =  $this->role->createRole($request->all());
        return redirect(url('admin/roles/create'));
    }
    /**
     * Display the specified resource.
     *授权视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $role = $this->role->getRole($id);
        return view('admin.roles.show')->with(compact('role'));
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
       $this->role->updateRole($request->all(),$id);
        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $this->role->destroyRole($id);
        return redirect('admin/roles');
    }
    /*
     * 授权
     * */
    public function upPermission(Request $request){
        $data = $request->all();
        $this->role->setRolePermission(explode(",", $data["permissionid"]),$data["id"]);
        return redirect('admin/roles');
    }
}
