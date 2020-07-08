<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/18
 * Time: 16:06
 */

namespace wangcb\permission\Traits;


use think\Collection;
use think\facade\Db;

trait HasPermission
{
    /**
     * 用户角色
     */
    public function can($permission){
        $permissions = $this->getAllPermissions()->toArray();
        $bool = false;
        if (is_string($permission)){
            $bool = in_array(strtolower($permission),array_column($permissions,'name'));
        }
        return $bool;
    }

    /**
     * 根据用户获取权限
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAllPermissions(){
        $roles = Db::name('model_has_roles')->where('model_id', $this->id)->column('role_id');
        $subsql = Db::name('role_has_permissions')->where('role_id','in',$roles)->field('permission_id')->buildSql();
        $permission = Db::name('permissions')->alias('a')
            ->join([$subsql=> 'b'],'a.id=b.permission_id')
            ->field('a.*')
            ->order('sort','desc')
            ->group('permission_id')
            ->select();
        return $permission;
    }

    public function getMenu(){
        $roles = Db::name('model_has_roles')->where('model_id', $this->id)->column('role_id');
        $subsql = Db::name('role_has_permissions')->where('role_id','in',$roles)->field('permission_id')->group('permission_id')->buildSql();
        $permission = Db::name('permissions')
            ->alias('a')
            ->join([$subsql=> 'b'],'a.id=b.permission_id')
            ->where('a.type','0')
            ->field('a.*')
            ->order('sort','desc')
            ->select()
            ->toArray();
        $arr = $this->arr2tree($permission,'id','parent_id');
        //var_dump($arr);
        return Collection::make($arr);
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    private function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'children') {
        $tree = $map = array();
        foreach ($list as $item) {
            $map[$item[$id]] = $item;
        }
        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            }
        }
        unset($map);
        return $tree;
    }

}