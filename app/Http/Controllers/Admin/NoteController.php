<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\Eloquent\Admin\Articles\NoteRepository;
use Illuminate\Http\Request;


class NoteController extends CommonController
{
    /**
     * Display a listing of the resource.
     * 便签
     * @return \Illuminate\Http\Response
     */
    private $note;    //日记仓库
    function __construct( NoteRepository $note)
    {
        //调用父累的构造方法
        parent::__construct('note');
        $this->note = $note;
    }


    public function ajaxIndex(Request $request){
        $result = $this->note->ajaxIndex($request->all());
        return response()->json($result);
    }
    /**
     * Display a listing of the resource.
     *便签
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.articles.note.list");
    }

    /**
     * Show the form for creating a new resource.
     *添加文章视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.articles.note.add");
    }

    /**
     * Store a newly created resource in storage.
     *添加日记逻辑
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result =  $this->note->createNote($request->all());
        return redirect(url('admin/note/create'));
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
        $noteEdit = $this->note->find($id);
        return view("admin.articles.note.edit")->with(compact('noteEdit'));
    }

    /**
     * Update the specified resource in storage.
     *修改日记逻辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->note->updateNote($request->all(),$id);
        return redirect('admin/note/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->note->destroyNote($id);
        return redirect(url('admin/note'));
    }

    /*
     * 批量删除
     * */
    public function destroys($id){
        //把json转换成数组然后用数组函数支取id列
        $id = array_column(json_decode($id),'id');
        $this->note->destroyNote($id);
        return redirect(url('admin/note'));
    }
}
