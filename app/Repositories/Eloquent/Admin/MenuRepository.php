<?php
namespace App\Repositories\Eloquent\Admin;
/**
 * Created by
 * User: 小强
 * Date: 2018/1/19
 * Time: 15:55
 * 说明：
 */
use App\Models\AminModels\Menu;
use App\Repositories\Eloquent\Repository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Cache;


class  MenuRepository extends Repository{
    private $userPs = '';  //该用户的权限
    private $adminRole = false; //是否事超级管理员
    public function model(){
        return Menu::class;
    }
    /*递归菜单层级关系*/
    public function sortMenus($menus,$pid = 0){
        $arr = [];
        if (empty($menus)){
            return '';
        }
        foreach ($menus as  $key => $v){
            if($v['parent_id'] == $pid ){
                $arr[$key] = $v;
                $arr[$key]['children'] = self::sortMenus($menus,$v['id']);
            }
        }
        return $arr;
    }
    /*查出菜单并排序子菜单*/
    public function  sortMenuSetCache(){
        //从查出菜单数据得到数组
        $menus = $this->model->orderBy('sort','desc')->get()->toArray();
        if ($menus){
            //得到菜单的层级关系
            $menusList = $this->sortMenus($menus);
            //对子菜单进行排序
            foreach ($menusList as $key => &$v){
                if($v['children']){
                    //提取子菜单的sort的所有列
                    $sort = array_column($v['children'],'sort');
                    //array_multisort是php的排序方法
                    array_multisort($sort,$v['children'],SORT_DESC);
                }
            }
                Cache::forever(config('admin.globals.cache.menusList'),$menusList);

           return $menusList;
        }
        return '';
    }
    /*从数据库中获取数据*/
    /*后台menus显示数据*/
    public function ajaxIndex($data){
        //得到模型
        $menu = $this->model;
        $menus = [];
        //判断是否有缓存如果有缓存直接从缓存里拿数据
        if(Cache::has(config('admin.globals.cache.menusList'))){
            $menus = Cache::get(config('admin.globals.cache.menusList'));
        }
        $menus = $this->model->orderBy('sort','desc')->get();
        $count = $menu->count();//查出所有数据的条数
        // datatables固定的返回格式
        return [
            'code' => 0,
            'msg' => '',//消息
            'count' => $count,//总条数
            'data' => $menus,//数据
             "is"=> true,
            "tip"=> "操作成功！"
        ];
    }
    /*得到成品的排过序的子菜单和菜单*/
    public function getMenuList(){
        //判断是否有缓存如果有缓存直接从缓存里拿数据
        if(Cache::has(config('admin.globals.cache.menusList'))){
            return Cache::get(config('admin.globals.cache.menusList'));
        }
        return $this->sortMenuSetCache();
    }


    /*修改菜单*/
    public function editMenu($id)
    {
        $menu = $this->model->find($id)->toArray();
        if ($menu) {
            $menu['update'] = url('admin/menu/'.$id);
            $menu['msg'] = '加载成功';
            $menu['status'] = true;
            return $menu;
        }
        return ['status' => false,'msg' => '加载失败'];
    }
    /**
     * 修改菜单
     * @author 晚黎
     * @date   2016-08-19
     * @param  [type]     $request [description]
     * @return [type]              [description]
     */
    public function updateMenu($request)
    {
        $menu = $this->model->find($request->id);
        if ($menu) {
            $isUpdate = $menu->update($request->all());
            if ($isUpdate) {
                $this->sortMenuSetCache();
                flash(trans('admin/alert.menu.edit_success'),'success');
                return true;
            }
            flash(trans('admin/alert.menu.edit_error'),'error');
            return false;
        }
        abort(404,'菜单数据找不到');
    }

    /**
     * 删除菜单
     * @author 晚黎
     * @date   2016-08-22T07:25:20+0800
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function destroyMenu($id){
        //删除
        $isDelete = $this->model->where('id',$id)->delete();
        //查看这个菜单如果有就把子菜单就把pid改成顶级菜单
        $this->model->where('parent_id',$id)->update(['parent_id'=>0]);
        if ($isDelete) {
            // 更新缓存数据
            $this->sortMenuSetCache();
            flash(trans('admin/alert.menu.destroy_success'),'success');
            return true;
        }
        flash(trans('admin/alert.menu.destroy_error'),'error');
        return false;
    }

    /*获取左边菜单json数据*/
    public function getMenuListJson(){
        $user = \Auth::user();
        $this->adminRole = $user->hasRole('admin'); //判断是否事超级管理员
        if(!$this->adminRole){  //如果不是超级管理员就获取当前用户的所有权限
            $this->userPs = $user->getAllPermissions();
        }
        $menu = [];
        if(Cache::has(config('admin.globals.cache.menusList'))){
            $menu = Cache::get(config('admin.globals.cache.menusList'));
        }else{
            $menu = $this->sortMenuSetCache();
        }
        return $this->getMenu($menu);
    }
    /*递归menu得到左边菜单数据*/
    public function getMenu($menus){
        $arr = [
        ];
        if (empty($menus)){
            return '';
        };
        $i = 0;
        foreach($menus as  $v){
            if($this->adminRole){ //如果是admin角色就直接显示所有列表
                $arr[$i]['mid'] = $v['id'];
                $arr[$i]['title'] = $v['name'];
                $arr[$i]['icon'] = $v['icon'];
                $arr[$i]['href'] = $v['url'];
                $arr[$i]['children'] = $this->getMenu($v['children']);
            }else{
                foreach ($this->userPs as $vl){ //如果不是就查看是否有权限显示
                    if($v['slug']==$vl->name ){
                        $arr[$i]['mid'] = $v['id'];
                        $arr[$i]['title'] = $v['name'];
                        $arr[$i]['icon'] = $v['icon'];
                        $arr[$i]['href'] = $v['url'];
                        $arr[$i]['children'] = $this->getMenu($v['children']);
                    }
                }
            }
            $i++;
        }
        return $arr;
    }
}
