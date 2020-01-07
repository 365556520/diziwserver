<?php

namespace App\Models\AminModels\Goods;

use Illuminate\Database\Eloquent\Model;

class GoodsCategorys extends Model
{
    //文章分类模型
    protected $table='goodscategorys';
    //这个表的路由的前缀
    private $action =  'goodscategorys';
    protected $fillable = [
        'goodscategorys_name',
        'goodscategorys_order',
        'goodscategorys_pid',
    ];

}
