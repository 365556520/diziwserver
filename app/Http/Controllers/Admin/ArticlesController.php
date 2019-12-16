<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\Articles\ArticlesRepository;
use App\Repositories\Eloquent\Admin\Articles\CategorysRepository;
use Illuminate\Http\Request;


class ArticlesController extends CommonController
{
    /**
     * 文章路由
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //文章分类仓库
    private $article;
    private $categorys;
    function __construct(ArticlesRepository $article,CategorysRepository $categorys)
    {

        //调用父累的构造方法
        parent::__construct('articles');
        $this->article = $article;
        $this->categorys = $categorys;

    }
    /*
 * 列表数据
 * */
    public function ajaxIndex(Request $request){
        $result = $this->article->ajaxIndex($request->all());
        return response()->json($result);
    }
    /*
     * 上传图片
     * */
    public function upload(Request $request){
        $upload = $request->file;
        if ($upload->isValid()) {
            //把图片放到临时文件家下面
            $path =  $upload->store('backend/images/articleImages');
            return ['code' => 0,'msg' =>'上传成功',  "data"=>["src"=> url($path)]];
        }
        return ['code' => 1,'msg' => '上传失败'];
    }
    /*
     * 删除图片
     *  右键删除视频图片的回调方法设置 calldel:{url:''},该设置会调用post方法传递图片(imgpath)/视频地址(filepath)
     *传递参数：
     *图片： imgpath --图片路径
     *视频： filepath --视频路径 imgpath --封面路径
     * */
    public function calldel(Request $request){
        $img =strrchr($request->all()['imgpath'],'/'); //获取图片名字
       if($img != ''){
           if ($this->article->deImg($img)) {
               return ['code' => 0,'msg' =>'删除成功',"data"=>["src"=> $request->all()['imgpath']]];
           }
       }
       return ['code' => 1,'msg' => '图片不存在删除失败',"data"=>["src"=> $request->all()['imgpath']]];
    }
    public function index()
    {
        //得到树列表
        $categorys=$this->categorys->getCategorysList();
        return view("admin.articles.articles.list")->with(compact('categorys','categorys'));
    }
    /**添加文章试图
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //得到树分类
        $categorys= $this->categorys->getCategorysList();
        return view("admin.articles.articles.add")->with(compact('categorys','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *添加文章
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //把内容存放到数据库
        $result = $this->article->createArticle($request->all());
        return redirect(url('admin/articles/create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //获取文章视图
    }

    /**
     * Show the form for editing the specified resource.
     *修改文章视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取文章视图
        $articlesEdit = $this->article->editView($id);
        //得到所有分类
        $categorys = $this->categorys->getCategorysList();
        return view("admin.articles.articles.edit")->with(compact('articlesEdit','categorys'));
    }

    /**
     * Update the specified resource in storage.
     *修改文章
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //修改文章
        $this->article->updateArticles($request->all(),$id);
        return redirect('admin/articles/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *删除文章
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //得到图片
        $thumb = $request->all()['thumb'];
        $this->article->destroyArticles($thumb,$id);
        return redirect(url('admin/articles'));
    }

    /*
     * 批量删除文章
     * */
    public function destroys(Request $request,$id){
        //得到图片
        $thumb = $request->all()['thumb'];
        //把json转换成数组然后用数组函数支取id列
        $id = array_column(json_decode($id),'id');
        $this->article->destroyArticles($thumb,$id);
        return redirect(url('admin/articles'));
    }

    /*
    * 文章审核
    * */
    public function state(Request $request){
        $result = $this->article->setState($request->all(),$request->all()['id']);
        if ($result) {
            return ['code' => 0,'msg' => '文章审核成功'];
        }
        return ['code' => 1,'msg' => '文章审核失败'];
    }
}
