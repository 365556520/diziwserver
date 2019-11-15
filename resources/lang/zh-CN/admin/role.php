<?php
return [
    'title' 	=> '角色管理',
    'desc' 		=> '角色列表',
    'create' 	=> '添加角色',
    'edit' 		=> '修改角色',
    'show'      => '查看角色',
    'model' 	=> [
        'id' 			=> 'ID',
        'name' 			=> '角色',
        'display_name' => '角色名称',
        'permission' => '权限',
        'description' 	=> '描述',
        'created_at' 	=> '创建时间',
        'updated_at' 	=> '修改时间',
        'operate' 	=> '操作',
    ],
    'action' => [
        'create' => '添加角色',
        'createDescription' => '添加角色需要管理员身份，才有权限添加。如果没有请联系管理员。',
    ],

];