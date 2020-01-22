<?php

namespace App\Models\AminModels\Articles;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //文章分类模型
    protected $table='comments';
    //这个表的路由的前缀
    public $action =  'comments';
    protected $fillable = [
        'topic_id',
        'topic_type',
        'content',
        'from_uid',
        'to_uid',
        'comments_pid',
    ];
    //得到评论的文章
    public function getArticles(){
        //反向关联
        return $this->belongsTo('App\Models\AminModels\Articles\Articles','topic_id');
    }
    //获取评论用户
    public function getFrom_uid(){
        //反向关联
        return $this->belongsTo('App\User','from_uid');
    }
    //获取评论用户
    public function getTo_uid(){
        //反向关联
        return $this->belongsTo('App\User','to_uid');
    }
}
