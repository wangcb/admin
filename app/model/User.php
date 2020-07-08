<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/18
 * Time: 16:16
 */

namespace app\model;


use think\Model;
use wangcb\permission\Traits\HasRole;

class User extends Model
{
    use HasRole;

    public $hidden = ['password'];


    /**
     * 写入后
     */
    public static function onAfterWrite($user){
        if ($user->roleids){
            $roleids = explode(',',$user->roleids);
            $user->roles($roleids);
        }
    }

    public static function onAfterDelete($user)
    {
        $user->clearRole();
    }
}