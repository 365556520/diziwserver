<?php
namespace App\Repositories\Contracts;
/**
 * 根据id查找用户接口
 * User: Administrator
 * Date: 2018/1/14
 * Time: 9:28
 * 自定义接口
 */
interface UserInterface
{

    public function findBy($id);
    public function userLogin($username,$password);
    public function isUser($lname,$data);
}