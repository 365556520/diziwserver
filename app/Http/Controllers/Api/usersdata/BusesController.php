<?php

namespace App\Http\Controllers\Api\usersdata;


use App\Models\AminModels\Buses\Buses;
use App\Models\AminModels\Buses\BusesRoute;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CommonController;
use DB;
use phpDocumentor\Reflection\Types\Array_;

class BusesController extends CommonController
{
    /*
     * 获取所有开始站点和终点（包括途径）
     * */
    public function getBusesRouteall(){
        $data =  BusesRoute::get();
        $newdata = [];
        foreach ($data as $k=>$v){
            $newdata['buses_start'][$k] = $v->buses_start;
            $newdata['buses_midway'][$k] = json_decode($v->buses_midway,true);
            $newdata['buses_end'][$k] = $v->buses_end;
        }
        //去出重复的始发地（array_unique去出数组中重复）
        $newdata['buses_start'] = array_unique($newdata['buses_start']);
        //终点和途经合并去重 (array_filter()去除数组中的空，用implode把路径数组转换成以点分割的字符串，然后在用explode以点分割转换成数组最后用array_merge把2个数组合并)
        $lv = []; //遍历途经的地名
        foreach($newdata['buses_midway'] as $v){
            if($v){
                foreach ($v as $d){
                    array_push($lv,$d);
                }
            }
        }
        $newdata['buses_end'] = array_filter(array_merge($newdata['buses_end'],$lv));
        //所有地名
        $newdata['buses_route_name'] = array_unique(array_merge($newdata['buses_start'],$newdata['buses_end']));
        return $this->response($newdata,'获取地名成功',200);
    }
    /*
     * 获取该线路所有车辆first 和find都是返回给模型
     * */
    public function getBuses($id){
        $data = BusesRoute::where('id',$id)->first()->getBuses;
        return $this->response($data);
    }
    /*
     * 起点和终点查出线路id
     * */
    public function getBusesRouteId(Request $request){
        $buses_start = $request->buses_start;
        $buses_end =  $request->buses_end;
        if(isset($buses_start)&&isset($buses_end)){
            //获取线路
            $data = BusesRoute::whereRaw('buses_start =? and buses_end = ?',[$buses_start,$buses_end])
                ->orWhere([['buses_start','=',$buses_start],['buses_midway','like','%'.$buses_end.'%']])
                ->get();
            if($data->isEmpty()){
                $data = BusesRoute::whereRaw('buses_end =? and buses_start = ?',[$buses_start,$buses_end])
                    ->orWhere([['buses_end','=',$buses_start],['buses_midway','like','%'.$buses_end.'%']])
                    ->get();
            }
            foreach ( $data as $k=>$v){
                $data[$k]['buses'] = $v->getBuses;
            }
            return $this->response($data,'车辆获取成功',200);
        }
        return $this->response('','请输入起始地和目的地',400);
    }
    /*
     * 获取该车信息
     * */
    public function busesInfo($busesname){
        $data = Buses::where('buses_name',$busesname)->with('getDriver','getBusesRoute')->get();
        return $this->response($data);
    }
    /*
     * 获取天气预报
     * */
    public function getWeatherForecast(Request $request){
        $ch = curl_init($request->url) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $result = curl_exec($ch);
        return $this->response($result);
    }
}
