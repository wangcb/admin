<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 17:16
 */

namespace app\validate;


use think\Validate;

class PermissionValidate extends Validate
{
    protected $rule =   [
        'name'  => 'require',
        'display_name'=>'require',
        'guard_name'    => 'require',
    ];
    protected $message  =   [
        'name.require'  => '地址不能为空',
        'display_name.require' => '名称不能为空',
        'guard_name.require' => 'guard_name不能为空',
    ];

    protected $scene = [
        'edit'      =>  ['id','display_name','guard_name'],
        'create'    =>  ['display_name','guard_name'],
    ];
}