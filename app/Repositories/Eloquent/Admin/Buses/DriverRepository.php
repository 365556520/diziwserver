<?php
namespace App\Repositories\Eloquent\Admin\Buses;

use App\Models\AminModels\Buses\Driver;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;

/**
 * 仓库模式继承抽象类
 * 驾驶员仓库
 */
class DriverRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return Driver::class;
    }
    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $driver = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        if ($data['reload']!= null) {
            //模糊查找name、id列
            $drivers = $driver->where($data["ifs"], 'like', "%{$data['reload']}%")->orWhere($data["ifs"],'like', "%{$data['reload']}%")->offset($start)->limit($length)->get();
            $count = $driver->where($data["ifs"], 'like', "%{$data['reload']}%")->orWhere($data["ifs"],'like', "%{$data['reload']}%")->count();//查出所有数据的条数
        }else{
            $drivers = $driver->offset($start)->limit($length)->get();//得到全部数据
            $count = $driver->count();//查出所有数据的条数
    }
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $drivers,//数据
        ];
    }
    /*添加驾驶员*/
    public function createDriver($formData){
        $result = $this->create($formData);
        if ($result) {
            flash('驾驶员添加成功','success');
        }else{
            flash('驾驶员添加失败','error');
        }
        return $result;
    }
    /*删除驾驶员*/
    public function destroyDriver($id){
       $result = false;
       if ($this->deletephoto($id)){
            $result = $this->delete($id);
       }
        if ($result) {
            flash('删除成功','success');
        } else {
            flash('删除失败','error');
        }
       return $result;
    }
    /*删除图片*/
    public function deletephoto($id){
        $result = $this->find($id);
        $driver_photo = true;
        if(!empty($result->driver_photo)){
            $driver_photo = strrchr($result->driver_photo,'/');
            //删除视频图片
            $driver_photo = Storage::delete(config('admin.globals.img.driver_photo').$driver_photo);
        }
        return $driver_photo;
    }
    /*批量删除*/
    public function destroyDrivers($thumb,$id){
        $result = false;
        $driver_photo = true;
        foreach ($thumb as $v){
            $driver_photo = strrchr($v,'/');
            if($driver_photo){
                //删除视频图片
                $driver_photo = Storage::delete(config('admin.globals.img.driver_photo').$driver_photo);
            }
        }
        $result = $this->delete($id);
        return $result;
    }
    // 修改驾驶员视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改驾驶员数据
    public function updateDriver($attributes,$id)
    {    // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        $result = $this->update($attributes,$id);
        if ($result) {
            flash('驾驶员信息修改成功','success');
        }else{
            flash('驾驶员信息修改失败', 'error');
        }
        return $result;
    }
}
