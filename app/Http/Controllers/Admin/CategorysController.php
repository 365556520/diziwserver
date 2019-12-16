<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\Articles\CategorysRepository;
use Illuminate\Http\Request;


class CategorysController extends CommonController
{
    /**
     * 文章分类
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //文章分类仓库
    private $categorys;
    function __construct(CategorysRepository $categorys)
    {
        //调用父累的构造方法
        parent::__construct('categorys');
        $this->categorys = $categorys;

    }

    public function index()
    {
        return view("admin.articles.categorys.list");
    }
    /*
     * 列表数据
     * */
    public function ajaxIndex(Request $request){
        $result = $this->categorys->ajaxIndex($request->all());
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *添加分类视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //得到所有分类
        $categorys= $this->categorys->getCategorysList();
        return view("admin.articles.categorys.add")->with(compact('categorys'));
    }
    /**
     * Store a newly created resource in storage.
     *添加文章分类
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result =  $this->categorys->createCategorys($request->all());
        return redirect(url('admin/categorys/create'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *修改分类视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorysEdit = $this->categorys->find($id);
        //得到所有分类
        $categorys = $this->categorys->getCategorysList();
        return view("admin.articles.categorys.edit")->with(compact('categorysEdit','categorys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //修改分类
        $this->categorys->updateCategorys($request->all(),$id);
        return redirect('admin/categorys/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = $this->categorys->destroyCategorys($id);
        return response()->json($msg);
    }

    /*
     * 批量删除
     * */
    public function destroys($data){
        //把json转换成数组然后用数组函数支取id列
        $id = array_column(json_decode($data),'id');
        $msg = $this->categorys->destroyCategorys($id);
        return response()->json($msg);
    }
}
