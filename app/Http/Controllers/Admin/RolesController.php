<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
// 引入 laravel-permission 模型
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class RolesController extends CommonController
{
/*    private $role;
    function __construct(RoleRepository $role){
        //调用父类的构造方法传
        parent::__construct('role');
        //role
        $this->role = $role;
    }*/
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
        $roles = Role::all();// 获取所有角色
        return $this->response(0,'数据更新成功',$roles);
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
        $roles = Role::create($request->all());
        if($roles){
            flash(trans('admin/alert.role.create_success'),'success');
        }else{
            flash(trans('admin/alert.role.create_error'), 'error');
        }
        return redirect(url('admin/roles/create'));
    }
    /**
     * Display the specified resource.
     *授权
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
        $role = $this->role->editView($id);
        return view('admin.roles.edit')->with(compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $role = Role::findOrFail($id);
        if ($role){
            $input = $request->all();
            $role->fill($input)->save();
        }
        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $role = Role::findOrFail($id);
        $result=$role->delete();
        if ($result) {
            flash(trans('admin/alert.role.destroy_success'),'success');
        } else {
            flash(trans('admin/alert.role.destroy_error'), 'error');
        }
        return redirect('admin/roles');
    }
    /*
     * 授权
     * */
    public function upPermission(Request $request){
        $data = $request->all();
        $this->role->setRolePermission(explode(",", $data["permission"]),$data["id"]);
        return redirect('admin/roles');
    }
}
