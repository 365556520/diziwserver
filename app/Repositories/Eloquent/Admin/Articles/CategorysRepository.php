<?php
namespace App\Repositories\Eloquent\Admin\Articles;

use App\Models\AminModels\Articles\Articles;
use App\Models\AminModels\Articles\Categorys;
use App\Repositories\Eloquent\Repository;


/**
 * 仓库模式继承抽象类
 */
class CategorysRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return Categorys::class;
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
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $categoryss,//数据
        ];
    }


    //得到的分类这个只能迭代2层分类
    public function getCategorysList($title = 'cate_name',$pid = "cate_pid"){
        $date = $this->model->select('id','cate_name as '.$title.'','cate_pid as '.$pid .'')->orderBy('cate_order','asc')->get();
        $categorysTree = $this->getTree($date,'cate_pid',0);
        return $categorysTree;
    }

    /*添加文章分类*/
    public function createCategorys($formData){
        $result = $this->create($formData);
        if ($result) {
            flash('文章分类添加成功','success');
        }else{
            flash('文章分类添加失败','error');
        }
        return $result;
    }
    /*删除文章分类*/
    public function destroyCategorys($id){
        $result = false;
        if($this->model->where('cate_pid',$id)->exists()){
            return ['code' => 0,'msg'=>'顶级分类下有子分类未删除！'];
        }else{
            if(Articles::where('category_id',$id)->exists()){
                return ['code' => 0,'msg'=>'此分类下有文章须清理文章后删除次分类！'];
            }else{
                $result = $this->delete($id);
            }
        }
        if ($result) {
            return ['code' => 200,'msg'=>'删除成功'];
        } else {
            return ['code' => 0,'msg'=>'删除失败'];
        }
    }

    // 修改文章分类视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改文章分类
    public function updateCategorys($attributes,$id)
    {    // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        $result = $this->update($attributes,$id);
        if ($result) {
            flash('文章分类修改成功','success');
        }else{
            flash('文章分类修改失败', 'error');
        }
        return $result;
    }
}
