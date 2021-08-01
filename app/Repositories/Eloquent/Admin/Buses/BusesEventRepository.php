<?php
namespace App\Repositories\Eloquent\Admin\Buses;

use App\Models\AminModels\Buses\busesevent;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;
use function Faker\Provider\pt_BR\check_digit;

/**
 * 仓库模式继承抽象类
 * 驾驶员仓库
 */
class BusesEventRepository extends Repository {
    //重写父类的抽象方法
    public function model(){

        return busesevent::class;
    }
    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $busesevent = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        if ($data['reload']!= null) {
            //模糊查找name、id列
            $busesevents = $busesevent->where($data["ifs"], 'like', "%{$data['reload']}%")->orWhere($data["ifs"],'like', "%{$data['reload']}%")->offset($start)->limit($length)->get();
            $count = $busesevent->where($data["ifs"], 'like', "%{$data['reload']}%")->orWhere($data["ifs"],'like', "%{$data['reload']}%")->count();//查出所有数据的条数
        }else{
            $busesevents = $busesevent->offset($start)->limit($length)->get();//得到全部数据
            $count = $busesevent->count();//查出所有数据的条数
    }
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $busesevents,//数据
        ];
    }
    /*添加车辆事件*/
    public function createBusesevent($formData){
        $result = $this->create($formData);
        if ($result) {
            flash('事件添加成功','success');
        }else{
            flash('事件添加失败','error');
        }
        return $result;
    }
    /*删除驾驶员*/
    public function destroyBusesevent($id){
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
        $photo = true;
        if(!empty($result->event_photo)){ //存在图片就删除
            $photo = strrchr($result->driver_photo,'/');
            //删除视频图片
            $photo = Storage::delete(config('admin.globals.img.driver_photo').$photo);
        }
        return $photo;
    }
    /*批量删除*/
    public function destroyBusesevents($thumb,$id){
        $result = false;
        $photo = true;
        //这里用到7牛目前先不用
     /*   foreach ($thumb as $v){
            $photo = strrchr($v,'/');
            if($photo){
                //删除视频图片
                $photo = Storage::delete(config('admin.globals.img.driver_photo').$photo);
            }
        }*/
        $result = $this->delete($id);
        return $result;
    }
    // 修改视图数据
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
            flash('修改成功','success');
        }else{
            flash('修改失败', 'error');
        }
        return $result;
    }
}
