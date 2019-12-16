<?php

namespace App\Models\AminModels\Articles;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ActionButtonTrait;

class Categorys extends Model
{
    //文章分类模型
    protected $table='categorys';
    //这个表的路由的前缀
    private $action =  'categorys';
    protected $fillable = [
        'cate_name',
        'cate_keywords',
        'cate_description',
        'cate_view',
        'cate_order',
        'cate_pid',
    ];

}
