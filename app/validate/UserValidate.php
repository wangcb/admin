<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 17:16
 */

namespace app\validate;


use app\model\User;
use think\Validate;

class UserValidate extends Validate
{
    protected $rule =   [
        'id'        => 'require',
        'username'  => 'require|length:4,12',
        'password'  => 'require|length:1,18',
        'nickname'  => 'length:1,6',
        'mobile'    => 'mobile',
        'repassword'=> 'require|confirm:password',
        'opassword' => 'require',
    ];
    protected $message  =   [
        'id.require'        => 'id不能为空',
        'username.require'  => '账号不能为空',
        'username.length'   => '账号长度4-12',
        'password.require'  => '密码不能为空',
        'password.length'   => '密码长度6-18',
        'nickname.nickname' => '昵称不能为空',
        'mobile.mobile'     => '手机号不能为空',
        'repassword.require'=> '请输入确认密码',
        'repassword.confirm'=> '两次密码不一致',
        'opassword.require' => '请输入原始密码',
    ];

    protected $scene = [
        'edit'      =>  ['id','nickname','mobile'],
        'create'    =>  ['username','password','nickname','mobile'],
        'state'     =>  ['id','state'],
        'password'  =>  ['opassword','password','repassword']
    ];
}