<?php

namespace App\Models\AminModels\Articles;

use Illuminate\Database\Eloquent\Model;


class Note extends Model
{
    //文章模型
    protected $table='note';
    //这个表的路由的前缀
    public $action =  'note';
    //这个表的路由的前缀
    protected $fillable = [
        'id',
        'title',
        'content',
        'user_id',
        'created_at',
    ];
    //获取作者
    public function getUser(){
        //反向关联
        return $this->belongsTo('App\User','user_id');
    }

    /*
     * 定义一个修改器
     * 这是过滤属性方法
     */
/*    public function setStartTimeAttribute($value)
    {

    }*/
    //自定义获取修改器 获取时间的时候只需要年月日 Y-m-d H:i:s
/*    public function getStartTimeAttribute()
    {
        return date('Y-m-d', $this->attributes['created_at']);
    }*/
}
