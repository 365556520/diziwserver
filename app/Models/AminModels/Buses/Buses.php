<?php

namespace App\Models\AminModels\Buses;

use Illuminate\Database\Eloquent\Model;

class Buses extends Model
{
    //班车模型
    protected $table='buses';

    //这个表的路由的前缀
    public $action =  'buses';
    protected $fillable = [
        'buses_name',
        'busesroute_id',
        'buses_type',
        'buses_sit',
        'buses_approve_date',
        'buses_insurance_date',
        'buses_driver_id',
        'buses_boss',
        'buses_phone',
        'buses_start_date',
        'buses_end_date',
    ];
    //获取驾驶员
    public function getDriver()
    {
        return $this->belongsTo('App\Models\AminModels\Buses\Driver', 'buses_driver_id');
    }
    //获取营运线路
    public function getBusesRoute()
    {
        return $this->belongsTo('App\Models\AminModels\Buses\BusesRoute', 'busesroute_id');
    }
}
