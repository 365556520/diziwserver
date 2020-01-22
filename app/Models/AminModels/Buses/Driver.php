<?php

namespace App\Models\AminModels\Buses;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //驾驶员模型
    protected $table = 'driver';

    //这个表的路由的前缀
    public $action = 'driver';
    protected $fillable = [
        "driver_name",
        "driver_phone",
        "driver_age",
        "driver_sex",
        "driver_card",
        "driver_card_firstdata",
        "driver_photo",
        "driver_archive_number",
        "driver_card_date",
        "driver_permit",
        "driver_qualification",
        "driver_qualification_date",
        "driver_info",
    ];
    //获取驾驶的车辆
     public function getBuses()
     {
          return $this->hasOne('App\Models\AminModels\Buses\Buses', 'buses_driver_id');
     }
}
