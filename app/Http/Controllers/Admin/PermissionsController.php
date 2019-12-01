<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PermissionsRequest;
use App\Repositories\Eloquent\Admin\Rabc\PermissionsRepository;
use App\Repositories\Eloquent\Admin\Rabc\RolesRepository;
use Spatie\Permission\Models\Permission;


class PermissionsController extends CommonController
{
  /*  private $permissions;
    private $role;
    function __construct(PermissionsRepository $permissions,RolesRepository $role)
    {

        $this->role = $role;
        //注入permissions的model
        $this->permissions = $permissions;

    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.permissions.list');
    }
//权限表DataTables
    public function ajaxIndex(){
        $permissions = Permission::all(); // 获取所有权限
        return ['code' => 0,'msg' => '数据更新成功','data' =>$permissions];
    }

    /**
     * 添加视图
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.permissions.create');
    }

    /**
     * 添加内容
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $permissions = $this->permissions->createPermission($request->all());
        if ($permissions){
            /*添加成功后更新超级管理员的权限*/
            $this->role->upadmin(config('admin.globals.upadmin.name'),config('admin.globals.upadmin.admin'));
        }
        return redirect(url('admin/permissions'));
    }

    /**
     * 显示内容查看的
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $permissions = $this->permissions->find($id);
         return view('admin.permissions.show')->with(compact('permissions'));
    }

    /**
     * 点击修改获取要这条记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $permissions = $this->permissions->editView($id);
        return view('admin.permissions.edit')->with(compact('permissions'));
    }

    /**
     * 修改内容提交到数据库
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $permissions = $this->permissions->updatePermission($request->all(),$id);
        if ($permissions){
            /*修改成功后更新超级管理员的权限*/
            $this->role->upadmin(config('admin.globals.upadmin.name'),config('admin.globals.upadmin.admin'));
        }
        return redirect('admin/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissions = $this->permissions->destroyPermission($id);
        if ($permissions){
            /*删除成功后更新超级管理员的权限*/
            $this->role->upadmin(config('admin.globals.upadmin.name'),config('admin.globals.upadmin.admin'));
        }
        return redirect('admin/permissions');
    }
}
