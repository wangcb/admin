<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/14
 * Time: 13:57
 */

namespace app\exception;


use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\Response;
use Throwable;


class Exception extends Handle
{
    public function render($request, Throwable $e): Response
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            return json(new ErrorException(422,$e->getError()), 200);
            //return json($e->getError(), 422);
        }

        // 请求异常
        if ($e instanceof HttpException && $request->isAjax()) {
            return json(new ErrorException($e->getStatusCode(), $e->getMessage()), 200);
        }

        $code = method_exists($e,'getStatusCode') ? $e->getStatusCode() : 500;
        $message = $e instanceof \Error && env('APP_DEBUG') ? $e->getFile()." ".$e->getLine()." ".$e->getMessage() : $e->getMessage();
        return json(new ErrorException( $code, $message), 200);

    }

}