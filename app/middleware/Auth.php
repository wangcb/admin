<?php
declare (strict_types = 1);

namespace app\middleware;
use app\controller\Notify;
use app\exception\ErrorException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use think\model\Collection;
use think\Response;


/**
 * 权限判断中间件
 * Class Auth
 * @package app\middleware
 */
class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //

        $header = [
            'Content-Type'=>'application/json; charset=utf-8',
            'Access-Control-Allow-Origin'=>'*',
            'Access-Control-Allow-Methods'=>'GET, POST, PATCH, PUT, DELETE',
            'Access-Control-Allow-Headers'=>'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With',
            'Access-Control-Max-Age'=>86400,
        ];
        if ($request->method() == 'OPTIONS'){
            return json('',200,$header);
        }
        $response   = $next($request);
        if($request->controller() == 'Notify') return $response;
        $response->header($header);
        //改变响应数据类型
        $obj       = $response->getData();
        if($obj instanceof ErrorException){
            return $response->data(['code'=>$obj->code,'msg'=>$obj->msg,'data'=>[]]);
        }
        $data       = $response->getContent();
        if (strpos($data,'<pre>array') !== false
            || strpos($data,'array') !== false)
            return $response;

        $arr        = json_decode($data,true);

        $content = [
            'code'  => 200,
            'msg'   => 'success',
            'data'  => is_null($arr) ? $data : $arr
        ];
        $response->content(json_encode($content,JSON_UNESCAPED_UNICODE));
        return $response;
    }
}
