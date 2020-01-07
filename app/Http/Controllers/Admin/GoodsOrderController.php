<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\Goods\GoodsOrderRepository;
use App\Repositories\Eloquent\Admin\Goods\GoodsRepository;
use Illuminate\Http\Request;


class GoodsOrderController extends CommonController
{
    /**
     * 订单路由
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //订单仓库
    private $goodsorder;
    //商品详细
    private $goods;
    function __construct(GoodsRepository $goods,GoodsOrderRepository $goodsorder)
    {
        //调用父累的构造方法
        parent::__construct('goodsorder');
        $this->goodsorder = $goodsorder;
        $this->goods = $goods;
    }

    public function index()
    {
        return view("admin.goods.goodsorder.list");
    }
    /*
     * 列表数据
     * */
    public function ajaxIndex(Request $request){
        $result = $this->goodsorder->ajaxIndex($request->all());
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *添加订单视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //得到所有商品
        $goods=  $this->goods->all();
        return view("admin.goods.goodsorder.add")->with(compact('goods'));
    }
    /**
     * Store a newly created resource in storage.
     *添加商品订单
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goodsData = $request->all();
        //更新商品数量
        $result = $this->goods->upSell($goodsData['buycount'],$goodsData['goods_id']);
        if ($result) {
            $this->goodsorder->createGoodsOrder($goodsData);
        }else{
            flash('订单添加失败库存不足！', 'error');
        }
        return redirect(url('admin/goodsorder/create'));
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
     *修改订单视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gsEdit = $this->goodsorder->find($id);
        //得到所有商品
        $goods=  $this->goods->all();
        return view("admin.goods.goodsorder.edit")->with(compact('gsEdit','goods'));
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
        $goodsData = $request->all();
        $result ='';
        $goodsorder = $this->goodsorder->find($id);
        if($goodsorder["goods_id"] == $goodsData['goods_id']){
            //不变更商品
            if($goodsData['buycount']>$goodsorder['buycount']){
                //增加订单数量
                $count = $goodsData['buycount']-$goodsorder['buycount'];
                $result =$this->goods->upSell($count,$goodsData['goods_id']);
            }elseif ($goodsData['buycount']<$goodsorder['buycount']){
                //减少订单数量
                $count = $goodsorder['buycount']-$goodsData['buycount'];
                $result =$this->goods->delSell($count,$goodsData['goods_id']);
            }else{
                $result = true;
            }
        }else{
            //变更商品后删除商品销量数
            $result = $this->goods->delSell($goodsorder['buycount'],$goodsorder['goods_id']);
            if($result){
                //减少新商品数量
                $result =$this->goods->upSell($goodsData['buycount'],$goodsData['goods_id']);
            }
        }
        if ($result) {
            $this->goodsorder->updateGoodsOrder($request->all(),$id);
        }else{
            flash('订单修改失败', 'error');
        }
        return redirect('admin/goodsorder/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $goodsData = $request->all();
        //更新商品数量
        $result = $this->goods->delSell($goodsData['buycount'],$goodsData['goods_id']);
        if ($result) {
            $this->goodsorder->destroyGoodsOrder($id);
        }else{
            flash('订单删除失败', 'error');
        }
        return redirect(url('admin/goodsorder'));
    }

}
