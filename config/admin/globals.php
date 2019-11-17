<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 2018/1/8
 * Time: 15:49
 *
 */
return[
    //自定义配置 登录名字
    'username' => 'username',
    //缓存的键值
    'cache' => [
        'menusList' => 'menusList',
    ],
    //列表开始表长度
    'list' => [
        'start' => 0,
        'length' => 10,
    ],
    //默认管理员更新
    'upadmin' =>[
        'name' => 'name',
        'admin' => 'admin',
    ],
    //图片默认存储位置
    'img' =>[
        'driver_photo' => 'backend/images/temp/driver'
    ]
];