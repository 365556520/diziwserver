<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\Articles\CommentsRepository;
use Illuminate\Http\Request;


class CommentsController extends CommonController
{

    /**
     * 评论
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //评论仓库
    private $comments;
    function __construct(CommentsRepository $comments)
    {
        //调用父累的构造方法
        parent::__construct('comments');
        $this->comments = $comments;

    }


    public function ajaxIndex(Request $request){
        $result = $this->comments->ajaxIndex($request->all());
        return response()->json($result);
    }
    /**
     * Display a listing of the resource.
     *文章评论
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.articles.comments.list");
    }

    /**
     * Show the form for creating a new resource.
     *添加文章视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.articles.comments.add");
    }

    /**
     * Store a newly created resource in storage.
     *添加评论逻辑
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result =  $this->comments->createComments($request->all());
        return redirect(url('admin/comments/create'));
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
     *修改视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commentsEdit = $this->comments->find($id);
        return view("admin.articles.comments.edit")->with(compact('commentsEdit'));
    }

    /**
     * Update the specified resource in storage.
     *修改评论逻辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->comments->updateComments($request->all(),$id);
        return redirect('admin/comments/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->comments->destroyComments($id);
        return redirect(url('admin/comments'));
    }

    /*
     * 批量删除
     * */
    public function destroys($data){
        //把json转换成数组然后用数组函数支取id列
        $id = array_column(json_decode($data),'id');
        $this->comments->destroyComments($id);
        return redirect(url('admin/comments'));
    }
}
