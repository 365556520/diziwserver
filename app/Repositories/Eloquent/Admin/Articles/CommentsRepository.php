<?php
namespace App\Repositories\Eloquent\Admin\Articles;

use App\Models\AminModels\Articles\Comments;
use App\Repositories\Eloquent\Repository;
use Mews\Purifier\Facades\Purifier;


/**
 * 仓库模式继承抽象类
 */
class CommentsRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return Comments::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到permission模型
        $comments = $this->model;
        $length = $data['limit']; //查询得条数
        $start = $data['page'] -1;//查询的页数 开始查询数据从0开始所以要减去1
        if ($start!=0){
            $start = $start*$length; //得到查询的开始的id
        }
        $count = $comments->count();//查出所有数据的条数
        $commentss = $comments->offset($start)->limit($length)->get();//得到分页数据
     //   $commentss = $this->getTreeOne($commentss,'to_uid','to_uid','from_uid','');
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $commentss,//数据
        ];
    }


    //得到的分类这个只能迭代2层分类
    public function getCategorysList($title = 'cate_name',$pid = "cate_pid"){
        $date = $this->model->select('id','cate_name as '.$title.'','cate_pid as '.$pid .'')->orderBy('cate_order','asc')->get();
        $categorysTree = $this->getTree($date,'cate_pid',0);
        return $categorysTree;
    }

    /*添加评论*/
    public function createComments($formData){
        //防止xxs攻击过滤
        $formData['content'] = Purifier::clean($formData['content'],array('Attr.EnableID' => true));
        $result = $this->model->create($formData);
        if ($result) {
            flash('评论添加成功','success');
        }else{
            flash('评论添加失败','error');
        }
        return $result;
    }
    /*删除评论*/
    public function destroyComments($id){
        $result = '';
        //删除子id
        if(is_array($id)){

           $arr = $this->model->select('id','comments_pid')->whereIn('id',$id)->get();
           foreach ($arr as $v){
              $this->delpid($v->id,$v->comments_pid );
           }
        }else{

            $vl = $this->find($id);
            $this->delpid($vl->id,$vl->comments_pid );
        }
        $result =  $this->delete($id);
        if ($result) {
            flash('删除成功','success');
        } else {
            flash('删除失败','error');
        }
        return $result;
    }
    //删除子类评论
    public function delpid($id ,$pid){
        $result = '';
        if($pid == 0){
            $result = $this->model->where('comments_pid',$id)->delete();
        }
        return $result;
    }

    // 修改评论视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改评论
    public function updateComments($attributes,$id)
    {    // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        //防止xxs攻击过滤
        $attributes['content'] =Purifier::clean($attributes['content']);
        $result = $this->update($attributes,$id);
        if ($result) {
            flash('评论修改成功','success');
        }else{
            flash('评论修改失败', 'error');
        }
        return $result;
    }
    //得到文章评论数
    public function getCommentsNumber($topic_id){
        $commentsNumber = 0;
        if(isset($topic_id)){
            $commentsNumber =  $this->model->where('topic_id',$topic_id)->count();
        }
        return $commentsNumber;
    }
    //获取该文章所有评论
    public function getComments($topic_id){
        if(isset($topic_id)){
            $commnets = $this->model->where('topic_id',$topic_id)->with('getFrom_uid.getUserData','getFrom_uid:id,name','getTo_uid:id,name')->orderBy('created_at','desc')->get();
            $commnets =  $this->getTree($commnets,'comments_pid',0);
            return $commnets;

        }else{
            return false;
        }
    }
}
