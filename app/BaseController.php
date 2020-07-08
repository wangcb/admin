<?php
declare (strict_types = 1);

namespace app;

use app\constants\ErrorCode;
use app\exception\ErrorException;
use app\exception\Exception;
use app\model\User;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use think\App;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    protected $isauth = true;
    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
        $path = $this->request->controller().'/'.$this->request->action();
        if (in_array($path,['Login/index','Index/verify'])){
            return true;
        }
        $jwt = $this->request->header('Authorization');
        if (!$jwt){
            $this->error(ErrorCode::TOKEN_NOT_FOUND);
        }
        $token = (new Parser())->parse(str_replace('Bearer ','',$jwt));

        $valid_token = new ValidationData();
        /*$valid_token->setIssuer('http://tv678.com');
        $valid_token->setAudience('http://tv678.com');
        $valid_token->setId('td8s1d13f27a5');*/
        if(!$token->validate($valid_token)){
            $this->error(ErrorCode::TOKEN_INVALID);
        }
        $user  =new User();
        $uid = $token->getClaim('uid');
        $username = $token->getClaim('username');
        $nick_name = $token->getClaim('nick_name');
        $user->id = $uid;
        $user->username = $username;
        $user->nickname = $nick_name;
        $this->user = $user;

        if ($this->isauth){
            $this->auth();
        }
    }

    function auth(){
        $path = $this->request->controller().'/'.$this->request->action();
		//路由白名单
        if(!in_array($path,['Login/index',
                'User/detail','User/menu',
                'User/password','User/edit',
                'Attribute/menu','Media/lists',
                'News/index','News/views',
            ])
            && $this->user->username != 'cloud'){
            $bool = $this->user->can($path);
            if (!$bool){
                $this->error(ErrorCode::NO_AUTHORITY);
            }
        }
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
				list($validate, $scene) = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }


    function error($code = 500, $msg='', $param = []){
        throw new HttpException($code, $msg);
    }

}
