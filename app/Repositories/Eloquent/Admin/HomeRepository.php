<?php
namespace App\Repositories\Eloquent\Admin;
use App\Models\UsersModel\User_Data;
use App\Repositories\Eloquent\Repository;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage
;
/**
 * 仓库模式继承抽象类
 */
class HomeRepository extends Repository {
    //重写父类的抽象方法
    public function model(){
        return User_Data::class;
    }
//        上传图片
    public function upimgage($img){
        if(empty($img)){
            flash("上传失败",'error');
            return view('admin.home.userdata');
        }else{
              header('Content-type:text/html;charset=utf-8');
             $base64_image_content = $img['icon'];
            //将base64编码转换为图片保存、、
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
                //图片后缀
                $type = $result[2];
                //绝对路径
                $new_file = "".public_path()."/backend/images/uploads/";
                if (!file_exists($new_file)) {
                    //检查是否有该文件夹，如果没有就创建，并给予最高权限
                    mkdir($new_file, 0700);
                }
                $imgname="img".time() . ".{$type}";
                $new_file = $new_file . $imgname;
                //将图片保存到指定的位置base64_decode把base64进行解码file_put_contents把字符串新到文件里面没有文件就从新创建一个
                if (file_put_contents($new_file, base64_decode(str_replace($result[1],'', $base64_image_content)))) {
                     // 如果不是默认照片就删除删除以前的图像用Storage::delete()修改了filesystems文件的默认路径
                    if ($img['past_img'] != '/backend/images/uploads/img.png'){
                        if(Storage::delete($img['past_img'])){
                            flash("上传成功",'success');
                        }
                    }else{
                        flash("上传成功",'success');
                    }
                    //保存成功返回这个相对路径和图片名字
                    return url('/backend/images/uploads/'.$imgname);
                }else{
                    return 'false';
                }
            }else{
                return 'false';
            }
        }
    }

    // 修改用户信息
    public function updateUser($attributes,$id){
        // 防止用户恶意修改表单id，如果id不一致直接跳转500
        if ($attributes['id'] != $id) {
            abort(500,trans('admin/errors.user_error'));
        }
        //更新这个角色的数据
        $result = $this->update($attributes,$id);
        if ($result) {
            flash(trans('admin/alert.role.edit_success'),'success');
        } else {
            flash(trans('admin/alert.role.edit_error'), 'error');
        }
        return $result;
    }

}