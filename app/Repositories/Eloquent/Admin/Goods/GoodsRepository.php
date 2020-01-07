<?php
namespace App\Repositories\Eloquent\Admin\Goods;


use App\Models\AminModels\Goods\Goods;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;


/**
 * 仓库模式继承抽象类
 */
class GoodsRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return Goods::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $articles = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        if($data['goodscategorys_id'] != null){
            $articless = $articles->where('goodscategorys_id',$data['goodscategorys_id'])->offset($start)->limit($length)->get();//得到分页数据
            $count = $articles->where('goodscategorys_id',$data['goodscategorys_id'])->count();//查出所有数据的条数
        }else{
            $articless = $articles->offset($start)->limit($length)->get();//得到全部数据
            $count = $articles->count();//查出所有数据的条数
        }
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $articless,//数据
        ];
    }

    /*添加商品*/
    public function createGoods($formData){
        $result = $this->model->create($formData);
        if ($result) {
            flash('商品添加成功','success');
        }else{
            flash('商品添加失败','error');
        }
        return $result;
    }
    /*删除商品
    */
    public function destroyGoods($id){
       //删除数据库数据
        $result = $this->delete($id);
        if ($result) {
            flash('删除成功','success');
        } else {
            flash('删除失败','error');
        }
    }

    // 修改商品视图数据
    public function editView($id)
    {
        //得到修改的数据
        $articlesEdit = $this->find($id);
        if ($articlesEdit) {
            return $articlesEdit;
        }
        abort(404);
    }
    // 修改商品信息
    public function updateGoods($attributes,$id)
    {    // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        $result = $this->update($attributes,$id);
        if ($result) {
            flash('商品信息修改成功','success');
        }else{
            flash('商品信息修改失败', 'error');
        }
        return $result;
    }
    //商品的数量增加
    public function upGoods($count,$id){
        $result = $this->model->where('id', $id)->increment('inventory', $count);
        return $result;
    }
    //商品的数量减少
    public function delGoods($count,$id){
        $result = $this->model->where([
            ['id', '=', $id],
            ['inventory', '>=',$count],
        ])->decrement('inventory', $count);
        return $result;
    }
    //销量增加
    public function upSell($count,$id){
        // 销量增加库存减少
        $result = $this->delGoods($count,$id);
        if($result){
            $this->model->where('id', $id)->increment('sell', $count);
        }
        return $result;
    }
    //销量减少
    public function delSell($count,$id){
        $result = $this->model->where([
            ['id', '=', $id],
            ['sell', '>=',$count],
        ])->decrement('sell', $count);
        if($result){
            // 销量减少库存增加
            $this->upGoods($count,$id);
        }
        return $result;
    }
}
