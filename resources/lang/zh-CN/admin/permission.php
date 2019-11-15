<?php
return [
    'title' 	=> '权限管理',
    'desc' 		=> '权限列表',
    'create' 	=> '添加权限',
    'edit' 		=> '修改权限',
    'show'      => '查看权限',
    'model' 	=> [
        'id' 			=> 'ID',
        'name' 			=> '权限',
        'display_name' => '权限名称',
        'description' 	=> '描述',
        'created_at' 	=> '创建时间',
        'updated_at' 	=> '修改时间',
        'operate' 	=> '操作',
    ],
    'action' => [
        'create' => '<i class="fa fa-plus"></i> 添加权限',
        'createDescription' => '添加权限需要管理员身份，才有权限添加。如果没有请联系管理员。',
    ],

];