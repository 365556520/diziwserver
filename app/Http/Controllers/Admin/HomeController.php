<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\MenuRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $menu;
    public function __construct(MenuRepository $menuRepository){
        $this->menu = $menuRepository;
    }
    /**
     * Show the application dashboard.
     *后台页面
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/index');
    }
    /*
     * 后台左边菜单列表、
     * */
    public function menus(){
        return ['code' => 200,"token"=>'','msg'=>'成功获取列表','data' => $this->menu->getMenuListJson()];

    }
}
