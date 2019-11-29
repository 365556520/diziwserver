<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\Admin\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller {
    private $menu;
    public function __construct(MenuRepository $menuRepository){

            $this->menu = $menuRepository;
    }
    //菜单icons代码
    public function icons(){
        return view('admin.menu.icons');
    }
    public function index(){
        //查出顶级菜单
        $menu = $this->menu->findByField('parent_id',0);
        //按照层级关系得到所有菜单
        $menuList = $this->menu->getMenuList();
        //进入的时候刷新缓存
        $this->menu->sortMenuSetCache();
        return view('admin.menu.list')->with(compact('menu','menuList'));
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
        return view('admin.menu.add');
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
    public function update(Request $request)
    {
        $request->validate([
          'name' => 'required|unique:menus,name',
          'parent_id' => 'required',
          'url' => 'required',
          'slug' => 'required',
          'sort' => 'integer',
        ],[
          'name.required' => '菜单名称不能为空',
          'name.unique'  => '菜单名称已存在',
          'parent_id.required' => '菜单层级不能为空',
          'url.required' => '菜单url不能为空',
          'slug.required' => '菜单权限不能为空',
          'sort.integer' => '排序必须为整数'
        ]);
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
