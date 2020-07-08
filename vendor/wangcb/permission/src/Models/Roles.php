<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 16:37
 */

namespace wangcb\permission\Models;


use think\facade\Db;
use think\Model;

class Roles extends Model
{
    /**
     * 角色授权
     */
    public function permission($permission_id){
        $obj = $this;
        $res = 0;
        if ($permission_id){
            try{
                Db::transaction(function () use($obj, $permission_id, &$res){
                    Db::name('role_has_permissions')->where('role_id',$obj->id)->delete();
                    $data = [];
                    foreach ($permission_id as $v){
                        $data[] = [
                            'role_id' => $obj->id,
                            'permission_id'=> $v
                        ];
                    }
                    $res = Db::name('role_has_permissions')->insertAll($data);
                });
            }catch (\Exception $e){
                return false;
            }
        }else{
            try{
                $res = Db::name('role_has_permissions')->where('role_id',$this->id)->delete();
            }catch (\Exception $e){
                return false;
            }
        }
        return $res;
    }

    /**
     * 获取角色权限
     */
    public function getPermissions(){
        $subsql = Db::name('role_has_permissions')->where('role_id',$this->id)->field('permission_id')->buildSql();
        $permission = Db::name('permissions')->alias('a')->join([$subsql=> 'b'],'a.id=b.permission_id')->field('a.*')->select();
        return $permission;
    }

    /**
     * 获取菜单
     */
    public function menu($id = 0){
        $ids         = Db::name('role_has_permissions')->where('role_id',$id ? $id : $this->id)->column('permission_id');
        $permissions = Permissions::select();
        foreach ($permissions as &$permission){
            $permission->checked = in_array($permission->id,$ids);
        }
        return $permissions;
    }

    /**
     * 获取角色所有用户
     */
    public function users($id){
        $sql = Db::name('model_has_roles')->where('role_id',$id)->group('model_id')->buildSql(true);
        $res = Db::name('user')->alias('u')
            ->join([$sql=> 'r'], 'r.model_id=u.id')
            ->field('u.*')
            ->hidden(['password'])
            ->order('create_time','desc')
            ->select();
        return $res;
    }
}