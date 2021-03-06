<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MenuRequest;
use App\Repositories\Eloquent\Admin\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends CommonController {
    private $menu;
    public function __construct(MenuRepository $menuRepository){
        parent::__construct('menu');
        $this->menu = $menuRepository;
    }
    //菜单icons代码
    public function icons(){
        return view('admin.menu.icons');
    }
    public function index(){

        //按照层级关系得到所有菜单
        $menuList = $this->menu->getMenuList();
        //进入的时候刷新缓存
        $this->menu->sortMenuSetCache();
        return view('admin.menu.list')->with(compact('menuList'));
    }
    /*获取表单数据*/
    public function ajaxIndex(Request $request)
    {
        return $this->menu->ajaxIndex($request->all());
    }

    /**添加菜单视图
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //查出顶级菜单
        $menus = $this->menu->findByField('parent_id',0);
        return view('admin.menu.add')->with(compact('menus'));
    }

    /*添加菜单逻辑
     * */
    public function store(MenuRequest $request){
        $request = $this->menu->create($request->all());
        // 刷新缓存
        $this->menu->sortMenuSetCache();
        if($request){
            flash(trans('admin/alert.menu.create_success'),'success');

        }else{
            flash(trans('admin/alert.menu.create_error'),'flasherror');
        }
        return redirect('admin/menu/create');
    }
    /*修改菜单*/
    public function edit($id){
        $menu = $this->menu->editMenu($id);
        return response()->json($menu);
    }

    /**
     * 修改菜单数据
     */
    public function update(MenuRequest $request)
    {
        $this->menu->updateMenu($request);
        return redirect('admin/menu');
    }

    /**
     * 删除菜单
     */
    public function destroy($id){
        $this->menu->destroyMenu($id);
        return redirect('admin/menu');
    }
}
