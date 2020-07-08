<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 9:42
 */

namespace app\constants;


class ErrorCode
{
    const TOKEN_NOT_FOUND   = 1000;
    const INSERT_FAILED     = 1001;
    const UPDATE_FAILED     = 1002;
    const NO_AUTHORITY      = 1003;
    const TOKEN_INVALID     = 1004;
    const UPLOAD_FAILED     = 1005; //上传错误
    const CREDIT_LOW        = 1006;
    const RESOURCE_NOT_FOUND= 1007;
    const LOGIN_INVALID     = 1008;
    const USER_DISABLE      = 1009;
    const OPASSWORD_INVAL   = 1010;
    const NOT_PAY           = 1011;
    const CODE_INVAL        = 1012;

    static $arr = [
        self::TOKEN_NOT_FOUND   => 'token不能为空',
        self::INSERT_FAILED     => '添加失败',
        self::UPDATE_FAILED     => '修改失败',
        self::NO_AUTHORITY      => '没有权限',
        self::TOKEN_INVALID     => 'token无效或已过期',
        self::CREDIT_LOW        => '余额不足',
        self::RESOURCE_NOT_FOUND=> '资源不存在',
        self::LOGIN_INVALID     => '帐号或密码错误',
        self::USER_DISABLE      => '帐号已被禁用',
        self::OPASSWORD_INVAL   => '原始密码不正确',
        self::NOT_PAY           => '未支付',
        self::CODE_INVAL        => '验证码错误'
    ];

    static function getMessage($code, $param){
        $msg = isset(self::$arr[$code]) ? self::$arr[$code] :'未知错误';
        foreach ($param as $v){
            $msg = sprintf($msg,$v);
        }
        return $msg;
    }
}