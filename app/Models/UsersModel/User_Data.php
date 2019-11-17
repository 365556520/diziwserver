<?php

namespace App\Models\UsersModel;

use Illuminate\Database\Eloquent\Model;

class User_Data extends Model{
    protected $table='user_data';
    protected $fillable = [
        'id',
        'user_id',
        'nickname',
        'age',
        'sex',
        'ipone',
        'qq',
        'address',
        'hobby',
        'Readme',
    ];
}
