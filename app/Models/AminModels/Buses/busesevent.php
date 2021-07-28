<?php

namespace App\Models\AminModels\Buses;

use Illuminate\Database\Eloquent\Model;

class busesevent extends Model
{
    //
    protected $table = 'busesevent';

    //这个表的路由的前缀
    public $action = 'busesevent';
    protected $fillable = [
        "buses_id",
        "content",
        "event_photo",
        "event_time",
    ];
}
