<?php
namespace App\Repositories\Eloquent\Admin\Rabc;
/**
 * Created by
 * User: 小强
 * Date: 2018/1/19
 * Time: 15:55
 * 说明：
 */
use App\Models\Permission;
use App\Models\Permission_Role;
use App\Models\Role;
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
    //获取权限
    public function getAllPermissionList(){
        return Permission::all();
    }
    //添加角色
    public function createRole($attributes){

        $role = $this->model->create($attributes);
        if ($role){
            if (isset($attributes['permission'])) {
                /*添加权限*/
                $role->perms()->sync($attributes['permission']);
            }else{
                $role->perms()->sync([]);
            }
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
        if($this->isRoleAdmin($id)){
            abort(500,trans('admin/errors.role_error'));
        }else{
            $result = $this->delete($id);
            if ($result) {
                flash(trans('admin/alert.role.destroy_success'),'success');
            } else {
                flash(trans('admin/alert.role.destroy_error'), 'error');
            }
        }
        return $result;
    }
    // 修改权限视图数据
    public function editView($id)
    {
        $role = $this->find($id);
        //根据id获取角色所有权限
        $role['permission'] = $this->getRolePermission($id);
        if ($role) {
            return $role;
        }
        abort(404);
    }
    // 修改角色的权限数据
    public function updateRole($attributes,$id){
        //修改排除超级管理员
        // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id||$this->isRoleAdmin($id)) {
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
    /*角色授权*/
    public function setRolePermission($permissions,$id){
        $role =  Role::where('id',$id)->first();
        if (isset($permissions)) {
            //添加权限
            $role = $role->perms()->sync($permissions);
        }else{
            $role =  $role->perms()->sync([]);
        }
        if ($role) {
            flash("授权成功",'success');
        } else {
            flash("授权失败", 'error');
        }
        return $role;
    }
    /*获取角色数据*/
    public function getRole($id){
        $role = $this->model->find($id);
        //根据id获取角色所有权限
        $rolePermission =  $this->getRolePermission($id);
        $role['permission'] = Permission::whereIn('id',$rolePermission)->get();
        $role['notpermission'] = Permission::whereNotIn('id',$rolePermission)->get();
        return $role;
    }
    //获取角色权限
    public function getRolePermission($id){
        return Permission_Role::where('role_id',$id)->pluck('permission_id');
    }
    /*管理员获取全部权限*/
    public function upadmin($name='name',$admin='admin'){
        $role = Role::where($name,$admin)->first();
        if ($role){
            /*获取所有权限返回数组然后用array_column提取数组中id这列*/
          $role->perms()->sync(array_column($this->getAllPermissionList()->toArray(),'id'));
        }
    }
    /*超级管理员拦截*/
    public function isRoleAdmin($id){
        //超级管理不能修改数据
        return $this->model->where('id',$id)->first()->is_admin();
    }
}
