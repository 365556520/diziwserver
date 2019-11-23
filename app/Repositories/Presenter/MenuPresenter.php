<?php
namespace App\Repositories\Presenter;
/**
 * Presenter 模式辅助 View
 * User: 小强
 * Date: 2018/1/20
 * Time: 16:14
 * 说明：
 */
class MenuPresenter {
//   添加菜单下拉列表渲染
    public function getMenu($menus){
        if ($menus){
            $option = '<option value="0">顶级</option>';
            foreach ($menus as $v) {
                $option .=   '<option value="'.$v->id.'">'.$v->name.'</option>';
            }
            return $option;
        }
        return '<option value="0">顶级</option>';
    }
    //得到菜单列表
    public function getMenuList($menus){
        //获取当前用户对菜单的增删改查权限
        $menuAdd = auth()->user()->can(config('admin.permissions.menu.add')); //添加权限
        $menuEdit = auth()->user()->can(config('admin.permissions.menu.edit'));//编辑权限
        $menuDelete = auth()->user()->can(config('admin.permissions.menu.delete'));//删除权限
        if($menus){
            $item ='';
            foreach ($menus as $v){
                $item .= $this->getNestableItem($v,$menuAdd,$menuEdit,$menuDelete);
            }
            return $item;
        }
        return '暂无菜单';
    }
    /**
     * 返回菜单HTML代码 
     * 参数 $menuAdd  添加权限
     * $menuEdit 添加权限
     * $menuDelete 添加权限
     */
    protected function getNestableItem($menu,$menuAdd,$menuEdit,$menuDelete)
    {
        if ($menu['child']) {
            //如果有菜单就去得到子菜单
            return $this->getHandleList($menu['id'],$menu['name'],$menu['child'],$menuAdd,$menuEdit,$menuDelete);
        }
        if ($menu['parent_id'] == 0) {
//            没有子菜单的顶级菜单
            return '<li class="dd-item dd3-item" data-id="'.$menu['id'].'">
                    <div class="dd-handle dd3-handle"> </div>
                    <div class="dd3-content"> '.$menu['name'].$this->getActionButtons($menu['id'],$menuAdd,$menuEdit,$menuDelete).' </div>
                    </li>';
        }
//        返回子菜单
        return '<li class="dd-item dd3-item" data-id="'.$menu['id'].'">
                    <div class="dd-handle dd3-handle"> </div>
                    <div class="dd3-content"> '.$menu['name'].$this->getActionButtons($menu['id'],$menuAdd,$menuEdit,$menuDelete,false).' </div>
               </li>';
    }

    /**
     * 获取子集
     * @param  [type]     $id    [id]
     * @param  [type]     $name  [菜单名称]
     * @param  [type]     $child [菜单级别]
     * 参数 $menuAdd  添加权限
     * $menuEdit 添加权限
     * $menuDelete 添加权限
     * @return [type]            [description]
     */
    protected function getHandleList($id,$name,$child,$menuAdd,$menuEdit,$menuDelete)
    {
        $handle = '<li class="dd-item dd3-item" data-id="'.$id.'">
                        <div class="dd-handle dd3-handle"> </div>
                        <div class="dd3-content"> '.$name.$this->getActionButtons($id,$menuAdd,$menuEdit,$menuDelete).' </div>
                        <ol class="dd-list">';
        if ($child) {
            foreach ($child as $v) {
                $handle .= $this->getNestableItem($v,$menuAdd,$menuEdit,$menuDelete);
            }
        }
        $handle .= '</ol></li>';
        return $handle;
    }
    /**
     * 菜单按钮
     *    参数 $menuAdd  添加权限
     * $menuEdit 添加权限
     * $menuDelete 添加权限
     */
    protected function getActionButtons($id,$menuAdd ,$menuEdit ,$menuDelete ,$bool = true)
    {
        $action = '<div class="pull-right action-buttons">';
        if ($menuAdd && $bool) {
            //添加按钮
            $action .= '<a href="javascript:;" data-pid="'.$id.'" class="btn-xs createMenu" data-toggle="tooltip"data-original-title="添加"  data-placement="top"> <i class="fa fa-plus"></i></a>';
        }

        if ($menuEdit) {
            //修改按钮
            $action .= '<a href="javascript:;" data-href="'.url('admin/menu/'.$id.'/edit').'" class="btn-xs editMenu" data-toggle="tooltip"data-original-title="修改"  data-placement="top"><i class="fa fa-pencil"></i></a>';
        }

        if ($menuDelete) {
            //删除按钮
            $action .= '<a href="javascript:;" class="btn-xs destoryMenu" data-id="'.$id.'" data-original-title="删除"data-toggle="tooltip"  data-placement="top">
                            <i class="fa fa-trash"></i>
                            <form action="'.url('admin/menu',[$id]).'" method="POST" name="delete_item'.$id.'" style="display:none">
                                <input type="hidden"name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'">
                            </form>
                        </a>';
        }
        $action .= '</div>';
        return $action;
    }

    /**
     * 左侧菜单渲染
     * @param  string     $value [description]
     * @return [type]            [description]
     */
    public function sidebarMenus($menus){
        $html = '';
        if ($menus) {
            $html = '<li>';

            foreach ($menus as $v) {
               if (auth()->user()->can($v['slug'])) {
                    if ($v['child']) {
                        $html .= '<li class="'.active_class(if_uri_pattern(explode(',',$v['heightlight_url']))).'"><a><i class="'.$v['icon'].'"></i> '.$v['name'].' <span class="fa fa-chevron-down"></span></a>'.$this->getSidebarChildMenu($v['child']).'</li>';
                    }else{
                        $html .= '<li class="'.active_class(if_uri_pattern([$v['heightlight_url']])).'"><a href="'.url($v['url']).'"><i class="'.$v['icon'].'"></i> '.$v['name'].'</a></li>';
                    }
               }
            }
            $html .= '</li>';
        }
        return $html;
    }
    /**
     * 左侧菜单子菜单渲染
     * @param  string     $childMenu [description]
     * @return [type]                [description]
     */
    public function getSidebarChildMenu($childMenu=''){
        $html = '';
        if ($childMenu) {
            $html = '<ul class="nav child_menu" style="display:'.active_class(if_uri_pattern(['admin']),'block','none').'">';
            foreach ($childMenu as $v) {
              // if (auth()->user()->can($v['slug'])) { //判断列表权限。由于每条都会查询个sql会拖慢速度
                    $html .= '<li class="'.active_class(if_uri_pattern([$v['heightlight_url']]),'current-page').'"><a href="'.url($v['url']).'">'.$v['name'].'</a></li>';
              // }
            }
            $html .= '</ul>';
        }
        return $html;
    }
}