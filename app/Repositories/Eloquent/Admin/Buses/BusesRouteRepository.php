<?php
namespace App\Repositories\Eloquent\Admin\Buses;

use App\Models\AminModels\Buses\Buses;
use App\Models\AminModels\Buses\BusesRoute;
use App\Repositories\Eloquent\Repository;


/**
 * 仓库模式继承抽象类
 */
class BusesRouteRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return BusesRoute::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $rusesRoute = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        $count = $rusesRoute->count();//查出所有数据的条数
        $rusesRoutes = $rusesRoute->offset($start)->limit($length)->get();//得到分页数据
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $rusesRoutes,//数据
        ];
    }
    //得到的分类这个只能迭代2层分类
    public function getBusesRouteList(){
        $date = $this->model->select('id','buses_start','buses_midway','buses_end','buses_pid')->get();
        $categorysTree = $this->getTree($date,'buses_pid',0);
        return $categorysTree;
    }
    /*添加线路*/
    public function createBusesRoute($formData){
        //先一点为准把字符串转换成数组，然后把数组转化成json
        $formData['buses_midway'] = $this->getBuses_midwayJson($formData['buses_midway']);
        $result = $this->model->create($formData);
        if ($result) {
            flash('添加成功','success');
        }else{
            flash('添加失败','error');
        }
        return $result;
    }
    /*删除班车线路*/
    public function destroyBusesRoute($id){
        $result = false;
        if($this->model->where('buses_pid',$id)->exists()){
            flash('有子线路未删除,请先删除所有子线路！','success');
        }else{
            if(Buses::where('busesroute_id',$id)->exists()){
                flash('此线路下有班车,须清理班车后删除此线路！','success');
            }else{
                $result = $this->delete($id);
                if ($result) {
                    return ['code' => 200,'msg'=>'删除成功'];
                } else {
                    return ['code' => 0,'msg'=>'删除失败'];
                }
            }
        }
    }

    // 修改班车线路视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        //$result->buses_midway = json_decode($result->buses_midway); //把json转换成字符串
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改视频标签数据
    public function updateBusesRoute($attributes,$id)
    {    // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        //先一点为准把字符串转换成数组，然后把数组转化成json
        $attributes['buses_midway'] = $this->getBuses_midwayJson($attributes['buses_midway']);
        $result = $this->update($attributes,$id);
        if ($result) {
            flash('班线修改成功','success');
        }else{
            flash('班线修改失败', 'error');
        }
        return $result;
    }
    public function getBuses_midwayJson($buses_midway){
       return json_encode(explode(",", $buses_midway));
    }
    public function getpid(){
        return $this->model->where('buses_pid',0)->get();//返回父
    }
}
