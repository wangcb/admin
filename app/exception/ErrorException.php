<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 10:06
 */

namespace app\exception;


use app\constants\ErrorCode;
use think\Response;

class ErrorException
{
    public $code;
    public $msg = '';
    public $data = '';
    function __construct($code, $msg='', $param = [])
    {
        $this->code = $code;
        $this->msg = $msg ? $msg : ErrorCode::getMessage($code, $param);
    }
}