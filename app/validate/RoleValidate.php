<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 17:16
 */

namespace app\validate;


use think\Validate;

class RoleValidate extends Validate
{
    protected $rule =   [
        'id'            => 'require',
        'name'          => 'require',
    ];
    protected $message  =   [
        'id.require'    => 'id不能为空',
        'name.require'  => '名称不能为空'
    ];

    protected $scene = [
        'edit'      =>  ['id','name'],
        'create'    =>  ['name'],
    ];
}