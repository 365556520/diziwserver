<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\Goods\GoodsOrderRepository;
use App\Repositories\Eloquent\Admin\Goods\GoodsRepository;
use App\Repositories\Eloquent\Admin\Goods\GoodsCategorysRepository;
use App\Repositories\Eloquent\Admin\Goods\GoodsStockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class GoodsController extends CommonController
{
    /**
     * 商品路由
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //商品分类仓库
    private $goods;
    private $categorys;
    private $goodsorder;
    private $goodsstock;
    function __construct(GoodsRepository $goods,GoodsCategorysRepository $categorys,GoodsOrderRepository $goodsorder,GoodsStockRepository $goodsstock)
    {

        //调用父累的构造方法
        parent::__construct('goods');
        $this->goods = $goods;
        $this->categorys = $categorys;
        $this->goodsstock = $goodsstock;
        $this->goodsorder = $goodsorder;

    }
    /*
 * 列表数据
 * */
    public function ajaxIndex(Request $request){
        $result = $this->goods->ajaxIndex($request->all());
        return response()->json($result);
    }
    /*
     * 上传图片
     * */
    public function upload(Request $request){
        $upload = $request->file;
        if ($upload->isValid()) {
            //把图片放到临时文件家下面
            $path =  $upload->store('backend/images/goodsImages');
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
           if ($this->goods->deImg($img)) {
               return ['code' => 0,'msg' =>'删除成功',"data"=>["src"=> $request->all()['imgpath']]];
           }
       }
       return ['code' => 1,'msg' => '图片不存在删除失败',"data"=>["src"=> $request->all()['imgpath']]];
    }
    public function index()
    {
        //得到树列表
        $categorys=$this->categorys->getGoodsCategorysList();
        return view("admin.goods.goods.list")->with(compact('categorys'));
    }
    /**添加商品试图
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //得到树分类
        $categorys= $this->categorys->getGoodsCategorysList();
        return view("admin.goods.goods.add")->with(compact('categorys','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *添加商品
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //把内容存放到数据库
        $result = $this->goods->createGoods($request->all());
        return redirect(url('admin/goods/create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *修改商品视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取商品视图
        $goodsEdit = $this->goods->editView($id);
        //得到所有分类
        $categorys = $this->categorys->getGoodsCategorysList();
        return view("admin.goods.goods.edit")->with(compact('goodsEdit','categorys'));
    }

    /**
     * Update the specified resource in storage.
     *修改商品
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //修改商品
        $this->goods->updateGoods($request->all(),$id);
        return redirect('admin/goods/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *删除商品
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->goods->destroyGoods($id);
        return redirect(url('admin/goods'));
    }

    //商品home
    public function goodshome(){
           $goods =  $this->goods->all();
           //进货
           $goodsstock =  $this->goodsstock->all();
           //订单
           $goodsorder =  $this->goodsorder->all();
            //得到树列表
           $categorys=$this->categorys->getGoodsCategorysList();
        //总例利润
        $gosdsinfo= array("moneys"=>0,"buycount"=>0,"gross"=>0,"prices"=>0,"counts"=>0);
        foreach ($goods as &$v){
            $price=0;
            if($v->sell!=0){
                //获取实付价格和
                foreach ($goodsorder as $vl){
                    if($vl->goods_id == $v->id){ //判断订单手否是这个商品
                        $zcost=  $v->cost_price * $vl->buycount;//订单的成本价格
                        $price += $vl->totalprices - $zcost; //获取的利润
                        //总营业额
                        $gosdsinfo["gross"] += $vl->totalprices;
                    }
                }
            }
            $v->price = $price;
            //总利润
            $gosdsinfo["moneys"] += $price;
            //总销量
            $gosdsinfo["buycount"] += $v->sell;
        }
        foreach ($goodsstock as $v){
            $gosdsinfo["prices"] += $v->price;
            $gosdsinfo["counts"] += $v->count;
        }
        return view("admin.goods.goodshome")->with(compact('goods','goodsstock','goodsorder','categorys','gosdsinfo'));
    }

}
