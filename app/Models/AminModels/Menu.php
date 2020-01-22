<?php

namespace App\Models\AminModels;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //文章分类模型
    protected $table='menus';
    public $action =  'menus';
    protected $fillable = [
        'name',
        'icon',
        'parent_id',
        'slug',
        'url',
        'heightlight_url',
        'sort',
    ];
}
