<?php
namespace App\Repositories\Presenter;
use App\Repositories\Eloquent\Admin\UserRepository;
use Illuminate\Support\Facades\Auth;
/**
 * Presenter 模式辅助 View
 * User: 小强
 * Date: 2018/1/20
 * Time: 16:14
 * 说明：
 */
class AdminMenuPresenter {
    protected $user;  //用户
    protected $isUserPermissions; //用户所有权限
    /*注入仓库*/
    public function __construct(UserRepository $user){
        $this->user = $user;
    }
//   添加菜单下拉列表渲染
    public function getMenu($menus){
        if ($menus){
            $option = '<option value="0" selected >顶级</option>';
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
/*
    <button class="layui-btn">增加</button>
    <button class="layui-btn ">编辑</button>
    <button class="layui-btn">删除</button>
  </div>*/
        $action = '<div class="layui-btn-group" style="float:right ">';
        if ($menuAdd && $bool) {
            //添加按钮
            $action .= '<a href="javascript:;" data-pid="'.$id.'" class="createMenu"  style=" text-decoration: none;"> <i class="layui-icon"></i></a>';
        }

        if ($menuEdit) {
            //修改按钮
            $action .= '<a href="javascript:;" data-href="'.url('admin/menu/'.$id.'/edit').'" class="editMenu"   style=" text-decoration: none;"><i class="layui-icon"></i></a>';
        }

        if ($menuDelete) {
            //删除按钮
            $action .= '<a href="javascript:;" class="destoryMenu" data-id="'.$id.'">
                            <i class="layui-icon"></i>
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
        $arr = $this->user->getPermissions(Auth::user()->id,'name')->toArray(); //获取该用户权限
        //把二维数组转换一位数组
        $this->isUserPermissions = array_column($arr, 'name');
        $html = '';
        if ($menus) {
            foreach ($menus as $v) {
               if (in_array($v['slug'],$this->isUserPermissions)) {  //优化方该用户的全部权限后进行判断 老判断权限auth()->user()->can($v['slug'])
                    $html .= '<li class="layui-nav-item ">';
                        if ($v['child']) {
                            $html .= '
                               <a  href="javascript:;"><i class="'.$v['icon'].'"></i>'.$v['name'].'</a>                 
                               <dl class="layui-nav-child">
                                     '.$this->getSidebarChildMenu($v['child']).'  
                               </dl>
                            ';
                         // $html .= '<li class="'.active_class(if_uri_pattern(explode(',',$v['heightlight_url']))).'"><a><i class="'.$v['icon'].'"></i> '.$v['name'].' <span class="fa fa-chevron-down"></span></a>'.$this->getSidebarChildMenu($v['child']).'</li>';
                        }else{
                            $html .='<a  href="javascript:;" href-url="'.url($v['url']).'"><i class="'.$v['icon'].'"></i>'.$v['name'].'</a>';
                         /*   $html .= '<li class="'.active_class(if_uri_pattern([$v['heightlight_url']])).'"><a href="'.url($v['url']).'"><i class="'.$v['icon'].'"></i> '.$v['name'].'</a></li>';*/
                        }
                   }
                   $html .= '</li>';
            }
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
            foreach ($childMenu as $v) {
                if (in_array($v['slug'],$this->isUserPermissions)) {
                    $html .= '<dd><a href="javascript:;" href-url="' . url($v['url']) . '"><i class="layui-icon"></i>' . $v['name'] . '</a></dd>';
                }
            }
        }
        return $html;
    }
}