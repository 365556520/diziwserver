<?php

namespace App\Http\Controllers\Admin;


use App\Models\UsersModel\Buses\Buses;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\Admin\Buses\DriverRepository;

class DriverController extends CommonController
{
    /*驾驶员控制器*/
    private $driver;
    function __construct(DriverRepository $driver)
    {
        //调用父累的构造方法
        parent::__construct('driver');
        $this->driver = $driver;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.buses.driver.list');
    }


    //列表表DataTables
    public function ajaxIndex(Request $request){
        $result = $this->driver->ajaxIndex($request->all());
        return response()->json($result);
    }
    /*
   * 上传图片
   * */
    public function upload(Request $request){
        $upload = $request->file;
        if ($upload->isValid()) {
            //把图片放到临时文件家下面
            $path =  $upload->store(config('admin.globals.img.driver_photo'));
            if(isset($request->id)){
                //用仓库方法删除旧图片的方法
                $this->driver->deletephoto($request->id);
                //更新数据库图片路径
                $driver =  $this->driver->find($request->id);
                $driver->driver_photo = url($path);
                $driver->save();
                return ['status' => 0,'message' =>'修改成功','path' => url($path)];
            }
            return ['status' => 0,'message' =>'上传成功','path' => url($path)];
        }
        return ['status' => 1,'message' => '上传失败'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.buses.driver.add");
    }

    /**
     * 添加驾驶员
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //$request->except('_token')不获取_token的值，其他值正常获取
        $result = $this->driver->createDriver($request->except('_token','field'));
        return view("admin.buses.driver.add");
    }

    /**
     *显示视图
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = $this->driver->find($id);
        return view('admin.buses.driver.show')->with(compact('driver'));
    }

    /**
     * 显示修改驾驶员路视图
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = $this->driver->editView($id);
        return view('admin.buses.driver.edit')->with(compact('driver'));
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
        $this->driver->updateDriver($request->all(),$id);
        return redirect('admin/driver/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *单个删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Buses::where('buses_driver_id',$id)->exists()){
            return response()->json(['code' => 0,'msg'=>'删除失败，该驾驶员绑定有车辆！']);
        }else{
            $this->driver->destroyDriver($id);
            return response()->json(['code' => 200,'msg'=>'删除成功']);
        }
    }
    /*
    * 批量删除
    * */
    public function destroys(Request $request,$id){
        //把json转换成数组然后用数组函数支取id列
        $id = array_column(json_decode($id), 'id');
        if(Buses::whereIn('buses_driver_id',$id)->exists()){
            return response()->json(['code' => 0,'msg'=>'删除失败，有驾驶员绑定有车辆！']);
        }else {
            //得到图片
            $thumb = $request->all()['thumb'];
            $this->driver->destroyDrivers($thumb, $id);
            return response()->json(['code' => 200, 'msg' => '删除成功']);
        }
    }

}
