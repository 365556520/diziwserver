<?php
namespace App\Repositories\Eloquent\Admin\Rabc;
/**
 * Created by
 * User: 小强
 * Date: 2018/1/19
 * Time: 15:55
 * 说明：
 */


// 引入 laravel-permission 模型

use App\Models\AminModels\role_has_permissions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Repositories\Eloquent\Repository;



class  RolesRepository extends Repository{
    public function model(){
        return Role::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $role = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        $count = $role->count();//查出所有数据的条数
        $roles = $role->offset($start)->limit($length)->get();//得到分页数据
        // 固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $roles,//数据
        ];
    }
    //获取所有权限$guard_name  看守器
    public function getAllPermissionList($guard_name = null){
        if($guard_name != null){
            return Permission::where('guard_name',$guard_name)->get();
        }else{
            return Permission::all();
        }

    }
    //添加角色
    public function createRole($attributes){
        $role = $this->model->create($attributes);
        if($role){
            flash(trans('admin/alert.role.create_success'),'success');
        }else{
            flash(trans('admin/alert.role.create_error'), 'error');
        }
        return $role;
    }
    //删除角色
    public function destroyRole($id){
        $result =false;
        //删除排除超级管理员

        $result = $this->delete($id);
        if ($result) {
            flash(trans('admin/alert.role.destroy_success'),'success');
        } else {
            flash(trans('admin/alert.role.destroy_error'), 'error');
        }
        return $result;
    }

    // 修改角色数据
    public function updateRole($attributes,$id){
        //修改排除超级管理员
        // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.role_error'));
        }
        $result = $this->update($attributes,$id);
        if ($result) {
            flash(trans('admin/alert.role.edit_success'),'success');
        } else {
            flash(trans('admin/alert.role.edit_error'), 'error');
        }
        return $result;
    }
    /*角色授权
    $permissionsid  需要添加权限的id数组
    $id  角色id
    */
    public function setRolePermission($permissions,$id){
        $role =  Role::where('id',$id)->first();
        if (isset($permissions)) {
            //添加权限
            $role = $role->givePermissionTo($permissions);
        }
        if ($role) {
            flash("授权成功",'success');
        } else {
            flash("授权失败", 'error');
        }
        return $role;
    }
    /*撤销角色授权
    */
    public function  delRolePermission($permissions,$id){
        $role =  Role::where('id',$id)->first();
        if (isset($permissions)) {
            //删除角色有的权限
            $role = $role->revokePermissionTo($permissions);
        }
        if ($role) {
            flash("撤销授权成功",'success');
        } else {
            flash("撤销授权失败", 'error');
        }
        return $role;
    }
    /*获取角色所拥有的权限和没有的权限*/
    public function getRole($id){
        $role = $this->model->find($id);
        $role['role_permission'] =  $this->getRolePermission($id);   //根据id获取角色所有权限
        $role['permissions'] = $this->getAllPermissionList($role->guard_name); //获取该角色看守器相匹配的权限全部权限
        return $role;
    }
    //获取角色权限
    public function getRolePermission($id){
        return role_has_permissions::where('role_id',$id)->pluck('permission_id');
    }



    /*超级管理员拦截*/
    public function isRoleAdmin($id){
        //超级管理不能修改数据

    }
}
