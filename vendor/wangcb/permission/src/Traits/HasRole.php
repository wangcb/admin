<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/18
 * Time: 16:06
 */

namespace wangcb\permission\Traits;


use think\facade\Db;

trait HasRole
{
    use HasPermission;
    /**
     * 给用户分配角色
     */
    public function roles($roles){
        $obj = $this;
        $res = 0;
        Db::transaction(function () use($obj, $roles){
            Db::name('model_has_roles')->where('model_id',$obj->id)->delete();
            $data = [];
            foreach ($roles as $v){
                $data[] = [
                    'role_id' => $v,
                    'model_type'=> get_class($obj),
                    'model_id'  => $obj->id
                ];
            }
            $res = Db::name('model_has_roles')->insertAll($data);
        });
        return $res;
    }

    /**
     * 删除角色
     * @return int
     * @throws \think\db\exception\DbException
     */
    public function clearRole(){
        $res = Db::name('model_has_roles')->where('model_id',$this->id)->delete();
        return $res;
    }

    /**
     * 获取用户角色
     */
    public function getRoles(){
        $subsql = Db::name('model_has_roles')->where('model_id', $this->id)->field('role_id')->buildSql();
        $res = Db::name('roles')->alias('a')->join([$subsql=> 'b'],'a.id=b.role_id')->field('a.id,a.name,a.description')->select();
        return $res;
    }

    /**
     * 获取用户角色
     */
    public function hasRole($role){
        $res = Db::name('model_has_roles')->where('model_id', $this->id)->column('role_id');
        return in_array($role,$res);
    }

}