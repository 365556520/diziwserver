<?php

namespace App\Models\AminModels\Buses;

use Illuminate\Database\Eloquent\Model;

class BusesRoute extends Model
{
    //线路模型
    protected $table='busesroute';
    //这个表的路由的前缀
    public $action =  'busesroute';
    protected $fillable = [
        'buses_start',
        'buses_midway',
        'buses_end',
        'buses_pid',
    ];
    /**
     * 获取营运线路的车辆
     */
    public function getBuses()
    {
        return $this->hasMany('App\Models\AminModels\Buses\Buses','busesroute_id');
    }
}
