<?php
namespace App\Repositories\Eloquent\Admin\Articles;

use App\Models\AminModels\Articles\Note;
use App\Repositories\Eloquent\Repository;
use Mews\Purifier\Facades\Purifier;
use Auth;

/**
 * 仓库模式继承抽象类
 */
class NoteRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return Note::class;
    }

    /*权限表显示数据*/
    public function ajaxIndex($data){
        //得到模型
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


    /*添加日记*/
    public function createNote($formData){
        //防止xxs攻击过滤
        $formData['content'] = Purifier::clean($formData['content'],array('Attr.EnableID' => true));
        $result = $this->model->create($formData);
        if ($result) {
            flash('日记添加成功','success');
        }else{
            flash('日记添加失败','error');
        }
        return $result;
    }
    /*删除日记*/
    public function destroyNote($id){
        //删除日记
        $result =  $this->delete($id);
        if ($result) {
            flash('删除成功','success');
        } else {
            flash('删除失败','error');
        }
        return $result;
    }


    // 修改日记视图数据
    public function editView($id)
    {
        $result = $this->find($id);
        if ($result) {
            return $result;
        }
        abort(404);
    }
    // 修改日记
    public function updateNote($attributes,$id)
    {    // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        //防止xxs攻击过滤
        $attributes['content'] =Purifier::clean($attributes['content']);
        $result = $this->update($attributes,$id);
        if ($result) {
            flash('修改成功','success');
        }else{
            flash('修改失败', 'error');
        }
        return $result;
    }

    //api
    //获取某日的日记date_format(datetime,'%Y-%m-%d')
    public function getDayNote($date){
        $result = $this->model->select('title as price','content as data','created_at as date')->where('user_id',Auth::user()->id)->whereDate('created_at',$date)->get();
        return $result;
    }
 //获取某月的日记
    public function getMonthNote($year,$month){
        $result = $this->model->select('created_at as date')->where('user_id',Auth::user()->id)->whereYear('created_at', $year)->whereMonth('created_at',$month)->get();
        return $result;
    }


}
