<?php

namespace App\Models\AminModels\Goods;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //文章分类模型
    protected $table='goods';
    //这个表的路由的前缀
    private $action =  'goods';
    protected $fillable = [
        'user_id',
        'goods_name',
        'goods_title',
        'discount',
        'information',
        'goodscategorys_id',
        'shop_price',
        'cost_price',
        'goods_status',
        'aytype',
        'goods_number',
        'inventory',
        'sell',
        'goods_img'
    ];

}
