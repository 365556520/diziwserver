<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\Goods\GoodsRepository;
use App\Repositories\Eloquent\Admin\Goods\GoodsStockRepository;
use Illuminate\Http\Request;


class GoodsStockController extends CommonController
{
    /**
     * 商品进货路由
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //商品进货仓库
    private $goodsstock;
    //商品详细
    private $goods;
    function __construct(GoodsRepository $goods,GoodsStockRepository $goodsstock)
    {
        //调用父累的构造方法
        parent::__construct('goodsstock');
        $this->goodsstock = $goodsstock;
        $this->goods = $goods;
    }

    public function index()
    {
        return view("admin.goods.goodsstock.list");
    }
    /*
     * 列表数据
     * */
    public function ajaxIndex(Request $request){
        $result = $this->goodsstock->ajaxIndex($request->all());
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *添加商品进货视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //得到所有商品
        $goods=  $this->goods->all();
        return view("admin.goods.goodsstock.add")->with(compact('goods'));
    }
    /**
     * Store a newly created resource in storage.
     *添加商品商品进货
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goodsData = $request->all();
        $result =  $this->goodsstock->createGoodsStock($goodsData);
        //更新商品数量
        $this->goods->upGoods($goodsData['count'],$goodsData['goods_id']);
        return redirect(url('admin/goodsstock/create'));
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
     *修改商品进货视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $gsEdit = $this->goodsstock->find($id);
        //得到所有商品
        $goods=  $this->goods->all();
        return view("admin.goods.goodsstock.edit")->with(compact('gsEdit','goods'));
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
        $goodsstock = $this->goodsstock->find($id);
        //得到更新数量的差
        $count = $goodsData['count']-$goodsstock['count'];
        $this->goodsstock->updateGoodsStock($request->all(),$id);
        //更新商品数量
        $this->goods->upGoods($count,$goodsData['goods_id']);
        return redirect('admin/goodsstock/'.$id.'/edit');
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
        $this->goodsstock->destroyGoodsStock($id);
        //更新商品数量
        $this->goods->delGoods($goodsData['count'],$goodsData['goods_id']);
        return redirect(url('admin/goodsstock'));
    }

}
