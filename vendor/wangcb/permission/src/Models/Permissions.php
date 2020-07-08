<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/17
 * Time: 14:58
 */

namespace wangcb\permission\Models;


use think\facade\Db;
use think\Model;

class Permissions extends Model
{
    public static function onAfterDelete($obj)
    {
        Db::name('role_has_permissions')->where('permission_id',$obj->id)->delete();
    }
}