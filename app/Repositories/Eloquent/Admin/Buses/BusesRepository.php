<?php
namespace App\Repositories\Eloquent\Admin\Buses;

use App\Models\AminModels\Buses\Buses;
use App\Repositories\Eloquent\Repository;


/**
 * 仓库模式继承抽象类
 */
class BusesRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return Buses::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $buses = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }

        if ($data['reload']!= null) {
            //模糊查找name、id列
            $busess = $buses->where($data["ifs"], 'like', "%{$data['reload']}%")->orWhere($data["ifs"],'like', "%{$data['reload']}%")->offset($start)->limit($length)->get();
            $count = $buses->where($data["ifs"], 'like', "%{$data['reload']}%")->orWhere($data["ifs"],'like', "%{$data['reload']}%")->count();//查出所有数据的条数
        }else{
            if($data['busesroute_id'] != null){
                $busess = $buses->where('busesroute_id',$data['busesroute_id'])->offset($start)->limit($length)->get();//得到分页数据
                $count = $buses->where('busesroute_id',$data['busesroute_id'])->count();//查出所有数据的条数
            }elseif ($data["busesroute_ids"]!=null){
               $ids = json_decode($data["busesroute_ids"],true);//转换数组
                $busess = $buses->whereIn('busesroute_id',$ids)->offset($start)->limit($length)->get();//得到分页数据
                $count = $buses->whereIn('busesroute_id',$ids)->count();//查出所有数据的条数
            }else{
                $busess = $buses->offset($start)->limit($length)->get();//得到全部数据
                $count = $buses->count();//查出所有数据的条数
            }
        }
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $busess,//数据
        ];
    }

    /*添加班车*/
    public function createBuses($formData){
        $result = $this->model->create($formData);
        if ($result) {
            flash('添加成功','success');
        }else{
            flash('添加失败','error');
        }
        return $result;
    }
    /*删除班车*/
    public function destroyBuses($id){
        $result = $this->delete($id);
        if ($result) {
            flash('删除成功','success');
        } else {
            flash('删除失败','error');
        }
        return $result;
    }

    // 修改班车视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改班车
    public function updateBuses($attributes,$id)
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
