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
                $arr[$key]['child'] = self::sortMenus($menus,$v['id']);
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
                if($v['child']){
                    //提取子菜单的sort的所有列
                    $sort = array_column($v['child'],'sort');
                    //array_multisort是php的排序方法
                    array_multisort($sort,$v['child'],SORT_DESC);
                }
            }
            //添加到redios缓存
            Cache::forever(config('admin.globals.cache.menusList'),$menusList);
           return $menusList;
        }
        return '';
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
        $arr = [];
        if (empty($menus)){
            return '';
        };
        $i = 0;
        foreach($menus as  $v){
            $arr[$i]['mid'] = $v['id'];
            $arr[$i]['title'] = $v['name'];
            $arr[$i]['icon'] = $v['icon'];
            $arr[$i]['href'] = $v['url'];
            if(isset($v['child'])){ //判断是否有分类
                $arr[$i]['children'] = $this->getMenu($v['child']);
            }else{
                $arr[$i]['children']= [];
            }
            $i++;
        }
        return $arr;
    }
}
