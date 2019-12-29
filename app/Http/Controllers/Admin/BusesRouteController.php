<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BusesRouteRequest;
use App\Repositories\Eloquent\Admin\Buses\BusesRouteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusesRouteController extends CommonController
{
   private $busesroute;
    function __construct(BusesRouteRepository $busesroute)
    {
        //调用父累的构造方法
        parent::__construct('busesroute');
        $this->busesroute = $busesroute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.buses.busesroute.list');
    }


    //列表表DataTables
    public function ajaxIndex(Request $request){
        $result = $this->busesroute->ajaxIndex($request->all());
        return response()->json($result);
    }
    /**
     * Show the form for creating a new resource.
     *创建视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $busesroute = $this->busesroute->getpid(); //顶级线路
        return view('admin.buses.busesroute.add')->with(compact('busesroute'));
    }

    /**
     * 添加班车线路逻辑
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusesRouteRequest $request){
         $this->busesroute->createBusesRoute($request->except('_token'));
        return redirect(url('admin/busesroute/create'));
    }
    /**
     *显示视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * 显示修改班车线路视图
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $busesroute = $this->busesroute->editView($id);
        $pid = $this->busesroute->getpid();
        return view('admin.buses.busesroute.edit')->with(compact('busesroute','pid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusesRouteRequest $request, $id)
    {
        $this->busesroute->updateBusesRoute($request->all(),$id);
        return redirect('admin/busesroute');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = $this->busesroute->destroyBusesRoute($id);
        return response()->json($msg);
    }
}
