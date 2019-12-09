<?php
namespace App\Repositories\Eloquent\Admin\Rabc;

use App\Repositories\Eloquent\Repository;
use App\User;

/**
 * 仓库模式继承抽象类
 */
class UserRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return User::class;
    }
    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $user = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        $count = $user->count();//查出所有数据的条数
        $users = $user->offset($start)->limit($length)->get();//得到分页数据
        // 固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $users,//数据
        ];

    }
    /*添加用户*/
    public function createUser($formData){
        $result = $this->model->create([
            'name' => $formData['name'],
            'username' => $formData['username'],
            'email' => $formData['email'],
            'password' => bcrypt($formData['password']),
        ]);
        if ($result) {
            // 角色与用户关系
            if (isset($formData['role'])) {
                $result->roles()->sync($formData['role']);
            }else{
                $result->roles()->sync([]);
            }
            flash(trans('admin/alert.user.create_success'),'success');
        }else{
            flash(trans('admin/alert.user.create_error'),'error');
        }
        return $result;
    }
    /*删除用户*/
    public function destroyUser($id){
        $result = $this->delete($id);
        if ($result) {
            flash(trans('admin/alert.user.destroy_success'),'success');
        } else {
            flash(trans('admin/alert.user.destroy_error'),'error');
        }
        return $result;
    }
    // 修改角色的权限数据
    public function updateUser($attributes,$id){
        // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        //更新这个角色的数据
        $result = $this->update($attributes,$id);
        if ($result) {
            // 更新用户角色关系
            $user = User::where('id',$id)->first();
            if (isset($attributes['role'])) {
                $user->roles()->sync($attributes['role']);
            }else{
                $user->roles()->sync([]);
            }
            flash(trans('admin/alert.role.edit_success'),'success');
        } else {
            flash(trans('admin/alert.role.edit_error'), 'error');
        }
        return $result;
    }

    /*获取用户所有信息*/
    public function getUser($id){
       $user =  $this->model->where('id',$id)->first();
       if ($user){
           $user['role'] = Role::whereIn('id',$this->getRole($id))->get();
       }
       return $user;
    }
    /*得到用户角色*/
    public function getRole($id){
        return Role_User::where('user_id',$id)->pluck('role_id');
    }
    /*
    * 获取id用户的所有权限
     * $id  当前角色的id
     * $name 表列名
   */
    public function getPermissions($id,$name='*'){
        $role_id = $this->getRole($id); //获取当前用户角色id
        $permission_id =  rolehaspermissions::where('role_id',$role_id)->pluck('permission_id'); //获取当前用户权限id
        return Permission::select($name)->whereIn('id',$permission_id)->get();
    }

}
