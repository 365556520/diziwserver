<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;
/*仓库实实现类接口*/
abstract class Repository implements RepositoryInterface{
    /*App容器*/
    protected $app;
    /*操作model*/
    protected $model;
    public function __construct(Application $app) {
        $this->app = $app;
        $this->makeModel();
    }
    //抽象方法（实现类必须重写这个抽象方法）
    abstract function model();
    //返回一个实例的model
    public function makeModel(){
        //Container类中 $this->app->make 方法来代替 new model()的Class:
        $model = $this->app->make($this->model());
        /*是否是Model实例不是抛出异常*/
        if (!$model instanceof Model){
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->model = $model;
    }
    /*得到当前用户列表权限*/
    public function getUserPermissions($tableName){
        //得到权限
        $permissions = [
                       'show'=>auth()->user()->can(config('admin.permissions.'.$tableName.'.show')),//查看权限
                       'edit'=>auth()->user()->can(config('admin.permissions.'.$tableName.'.edit')),  //编辑权限
                       'delete'=>auth()->user()->can(config('admin.permissions.'.$tableName.'.delete'))];//删除权限
        return $permissions;
    }
    /*
     * 递归数组无限极分类
     *$date  需要递归的数组
     * $pId_Name 指pid的名称
     * $pId 指pid
     * */
    function getTree($date,$pId_Name, $pId)
    {
        $tree = array();
        foreach($date as $k => $v)
        {
            if($v[$pId_Name] == $pId)
            {        //父亲找到儿子
                $v['children'] = $this->getTree($date,$pId_Name,$v['id']);
                $tree[$k] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    //这个类处理树型列表参数说明：$date数据，$field_id父数据表头名,$field_pid子数据表头名，$pid父数据中的pid的值
    public function getTreeOne($date,$field_name,$field_id='id',$field_pid='pid',$pid=0){
        $arr = array();
        //遍历数据
        foreach ($date as $k=>$v){
            if($v->$field_pid==$pid) {
                $date[$k]["_".$field_name] =  $date[$k][$field_name];
                //如果该数据的cate_pid=0也就是总栏目的时候就把该数据添加在$arr[]
                $arr[] = $date[$k];
                //然后从新遍历数据
                foreach ($date as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        $date[$m]["_".$field_name] ='├─ '.$date[$m][$field_name];
                        //如果该数据的cate_pid=cate_id也就是子栏目cate_pid等于总栏目的cate_id的时候就把该数据添加在$arr[]
                        $arr[] = $date[$m];
                    }
                }
            }
        }
        return $arr;
    }

    public function all($columns = ['*']){
        return $this->model->all($columns);
    }

    public function find($id, $columns = ['*']){
        return $this->model->select($columns)->find($id);
    }
        /**
         * Find data by field and value
         *
         * @param       $field
         * @param       $value
         * @param array $columns
         *
         * @return mixed
         */
        public function findByField($field, $value, $columns = ['*']){
            $model = new $this->model;
            return $model->where($field,$value)->get();
        }
        /**
         * Find data by multiple fields
         *
         * @param array $where
         * @param array $columns
         *
         * @return mixed
         */
        public function findWhere(array $where, $columns = ['*']){

        }
        /**
         * Find data by multiple values in one field
         *
         * @param       $field
         * @param array $values
         * @param array $columns
         *
         * @return mixed
         */
        public function findWhereIn($field, array $values, $columns = ['*']){

        }
        /**
         * Save a new entity in repository
         *
         * @param array $attributes
         *
         * @return mixed
         */
        public function create(array $attributes){
            $model = new $this->model;
            return $model->fill($attributes)->save();
        }
        /**
         * 根据id更新数组
         *
         * @param array $attributes
         * @param       $id
         *
         * @return mixed
         */
        public function update(array $attributes, $id){
            $model = $this->model->findOrFail($id);
            return  $model->fill($attributes)->save();
        }
        /**
         * Update or Create an entity in repository
         *
         * @throws ValidatorException
         *
         * @param array $attributes
         * @param array $values
         *
         * @return mixed
         */
        public function updateOrCreate(array $attributes, array $values = []){
        }
        /**
         * Delete a entity in repository by id
         *
         * @param $id
         *
         * @return int
         */
        public function delete($id){
            return $this->model->destroy($id);
        }
        /**
         * Order collection by a given column
         *
         * @param string $column
         * @param string $direction
         *
         * @return $this
         */
        public function orderBy($column, $direction = 'asc'){

        }
        /**
         * Load relations
         *
         * @param $relations
         *
         * @return $this
         */
        public function with($relations){

        }
}