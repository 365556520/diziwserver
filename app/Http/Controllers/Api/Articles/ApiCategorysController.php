<?php

namespace App\Http\Controllers\Api\Articles;

use App\Repositories\Eloquent\Admin\Articles\CategorysRepository;
use App\Http\Controllers\Api\CommonController;


class ApiCategorysController extends CommonController
{
    /**
     * 文章分类API
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //文章分类仓库
    private $categorys;
    function __construct(CategorysRepository $categorys)
    {
        $this->categorys = $categorys;

    }
    public  function getCategorys(){
        $categorys = $this->categorys->getCategorysList();
        $getcategorys = array();
        foreach ($categorys as $v){
            if($v->children){
                foreach ($v->children as $vl)
                array_push($getcategorys,$vl);
            }
        }
        return $this->response($getcategorys,'文章分类获取成功','200');
    }
}
