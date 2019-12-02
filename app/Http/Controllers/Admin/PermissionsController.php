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
        $permissions = Permission::all(); // 获取所有权限
        return view('admin.permissions.add')->with(compact('permissions'));
    }

    /**
     * 添加内容
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsRequest $request)
    {
        $permission = Permission::create($request->all());
        if ($permission){
            flash(trans('admin/alert.permission.create_success'),'success');
        }else{
            flash(trans('admin/alert.permission.create_error'), 'error');
        }
      /*  if ($permission){
            //添加成功后更新超级管理员的权限
         //$this->role->upadmin(config('admin.globals.upadmin.name'),config('admin.globals.upadmin.admin'));
        }*/
        return redirect(url('admin/permissions/create'));
    }

    /**
     * 显示内容查看的
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

    }

    /**
     * 修改内容提交到数据库
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionsRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        if ($permission){
            $input = $request->all();
            $permission->fill($input)->save();
        }
        return redirect('admin/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *删除权限
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        if ($permission){
              $permission->delete();
        }
        return redirect('admin/permissions');
    }
}
