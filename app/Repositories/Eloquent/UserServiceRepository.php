<?php
namespace App\Repositories\Eloquent;
/**
 * 实现接口类
 * User: admin
 * Date: 2018/1/14
 * Time: 9:43
 */
use App\Models\User;
use App\Repositories\Contracts\UserInterface;

class UserServiceRepository implements UserInterface {
        public function findBy($id)
        {
            return User::find($id);
        }


    public function userLogin($username,$password){


    }

    public function isUser($lname,$data){

    }
}