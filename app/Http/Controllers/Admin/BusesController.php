<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\Eloquent\Admin\Buses\BusesRepository;
use App\Repositories\Eloquent\Admin\Buses\BusesRouteRepository;
use App\Repositories\Eloquent\Admin\Buses\DriverRepository;
use Illuminate\Http\Request;


class BusesController extends CommonController
{
    private $buses;
    //得到所有驾驶员
    private $driver;
    //得到所有线路
    private $busesRoute;
    function __construct(BusesRepository $buses,BusesRouteRepository $busesRoute,DriverRepository $driver)
    {
        //调用父累的构造方法
        parent::__construct('buses');
        $this->buses = $buses;
        $this->driver =$driver;
        $this->busesRoute = $busesRoute;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //得到所有驾驶员
        $driver =   $this->driver->all();
        //得到所有线路
        $busesRoute = $this->busesRoute->getBusesRouteList();
        return view('admin.buses.buses.list')->with(compact('driver','busesRoute'));
    }


    //列表表DataTables
    public function ajaxIndex(Request $request){
        $result = $this->buses->ajaxIndex($request->all());
        return response()->json($result);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //得到所有驾驶员
        $driver =   $this->driver->all();
        //得到所有线路
        $busesRoute = $this->busesRoute->getBusesRouteList();
        return view('admin.buses.buses.add')->with(compact('driver','busesRoute'));
    }

    /**
     * 添加班车线路
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //$request->except('_token')不获取_token的值，其他值正常获取
        $result = $this->buses->createBuses($request->except('_token'));
        return redirect(url('admin/buses'));
    }

    /**
     *显示视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buses = $this->buses->find($id);
        return view('admin.buses.buses.show')->with(compact('buses'));
    }

    /**
     * 显示修改班车视图
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //得到所有驾驶员
        $driver =   $this->driver->all();
        //得到所有线路
        $busesRoute = $this->busesRoute->getBusesRouteList();
        $buses = $this->buses->editView($id);
        return view('admin.buses.buses.edit')->with(compact('buses','driver','busesRoute'));
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

        $this->buses->updateBuses($request->all(),$id);
        return redirect('admin/buses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            //把json转换成数组然后用数组函数支取id列
        $id = array_column(json_decode($id),'id');
        $this->buses->destroyBuses($id);
        return redirect(url('admin/buses'));
    }
}
