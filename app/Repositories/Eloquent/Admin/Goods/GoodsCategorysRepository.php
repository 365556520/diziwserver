<?php
namespace App\Repositories\Eloquent\Admin\Goods;


use App\Models\AminModels\Goods\GoodsCategorys;
use App\Repositories\Eloquent\Repository;


/**
 * 仓库模式继承抽象类
 */
class GoodsCategorysRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return GoodsCategorys::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){

        //得到permission模型
        $categorys = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        $count = $categorys->count();//查出所有数据的条数
        $categoryss = $categorys->offset($start)->limit($length)->get();//得到分页数据
        $categoryss = $this->getTreeOne($categoryss,'goodscategorys_name','id','goodscategorys_pid',0);
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $categoryss,//数据
        ];
    }


    //得到的分类这个只能迭代2层分类
    public function getGoodsCategorysList($title = 'goodscategorys_name',$pid = "goodscategorys_pid"){
        $date = $this->model->select('id','goodscategorys_name as '.$title.'','goodscategorys_pid as '.$pid .'')->orderBy('goodscategorys_order','asc')->get();
        $categorysTree = $this->getTree($date,'goodscategorys_pid',0);
        return $categorysTree;
    }

    /*添加商品分类*/
    public function createGoodsCategorys($formData){
        $result = $this->model->create($formData);
        if ($result) {
            flash('商品分类添加成功','success');
        }else{
            flash('商品分类添加失败','error');
        }
        return $result;
    }
    /*删除商品分类*/
    public function destroyGoodsCategorys($id){
        $result = $this->delete($id);
        if ($result) {
            flash('删除成功','success');
        } else {
            flash('删除失败','error');
        }
        return $result;
    }

    // 修改商品分类视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改商品分类
    public function updateGoodsCategorys($attributes,$id)
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
