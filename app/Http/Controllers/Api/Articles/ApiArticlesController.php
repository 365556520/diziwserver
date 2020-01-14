<?php

namespace App\Http\Controllers\Api\Articles;

use App\Repositories\Eloquent\Admin\Articles\ArticlesRepository;
use App\Http\Controllers\Api\CommonController;
use App\Repositories\Eloquent\Admin\Articles\CommentsRepository;
use Illuminate\Http\Request;
use Auth;


class ApiArticlesController extends CommonController
{
    /**
     * 文章API
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //文章仓库
    private $articles;
    //评论
    private $comments;
    function __construct(ArticlesRepository $Articles,CommentsRepository $Comments)
    {
        $this->articles = $Articles;
        $this->comments = $Comments;
    }
    //获取文章列表
    public  function getArticles(Request $request){
        $data = $request->all();
        $data['limit']=(int)$data['limit'];
        $data['page']=(int)$data['page'];
        $result = $this->articles->getArticles($data);
        $result['data'] = $this->articles->getimgurl($result['data']);
        return $this->response($result,'backend/images/articleImages/','200');
    }
    //获取文章内容
    public function getArticlesContent($id){
        $content = $this->articles->getArticlesContent($id);
        $content['commentsnumber'] = $this->comments->getCommentsNumber($id);
        return $this->response($content,'文章内容获取成功','200');
    }

    //添加评论
    public function inputComments(Request $request){
        $data = $request->all();
        $data['data']['from_uid'] = Auth::user()->id;
        $result = $this->comments->createComments($data['data']);
        if($result){
            return $this->response('','评论成功','200');
        }else{
            return $this->response('','评论失败','0');
        }
    }
    //获取该文章所有评论 id为文章id
    public function getComments($id){
        $result = $this->comments->getComments($id);
        if($result){
            return $this->response($result,'获取成功','200');
        }else{
            return $this->response($result,'评论获取失败','0');
        }
    }
}
