<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/13
 * Time: 13:40
 */

namespace app\controller;


use app\BaseController;
use app\constants\ErrorCode;
use Lcobucci\JWT\Builder;
use app\model\User;
use think\Collection;
use think\facade\Db;


class Login extends BaseController
{
    /**
     * 登录
     */
    public function index(){
        $username   = $this->request->param('username');
        $password   = $this->request->param('password');
        $code       = $this->request->param('code');
        $key        = $this->request->param('key');
        if (!password_verify(mb_strtolower($code, 'UTF-8'), $key)){
            $this->error(ErrorCode::CODE_INVAL);
        }

        $user = User::where('username',$username)->find();
        if ($user){
            if($user->state) $this->error(ErrorCode::USER_DISABLE);
            if ($user->password == password($password)){
                $time = $this->request->server('REQUEST_TIME');
                $token = (new Builder())
                    ->issuedBy('http://tv678.com')
                    ->permittedFor('http://tv678.com')
                    ->identifiedBy('td8s1d13f27a5',true)
                    ->issuedAt($time)
                    ->expiresAt($time + 604800)
                    ->withClaim('uid',$user->id)
                    ->withClaim('username',$user->username)
                    ->withClaim('nick_name',$user->nick_name)
                    ->getToken();

                //登录日志
                Db::name('login_log')->insert([
                    'ip'    => $this->request->ip(),
                    'userid'=> $user->id,
                    'create_time'=>date('Y-m-d H:i:s')
                ]);

                return (string)$token;
            }else{
                $this->error(ErrorCode::LOGIN_INVALID);
            }
        }
        $this->error(ErrorCode::RESOURCE_NOT_FOUND);
    }

    public function log(){
        $page   = $this->request->param('page',1);
        $limit  = $this->request->param('limit',10);
        $range  = $this->request->param('create_time','');
        $keyword= $this->request->param('keyword','');
        $where  = [];
        if ($this->user->username != 'admin'){
            $where[] = ['userid','=',$this->user->id];
        }
        if ($range){
            [$start,$end] = explode('~',$range);
            if ($start) $where[] = ['l.create_time','>',$start.' 00:00:00'];
            if ($end) $where[] = ['l.create_time','<',$end.' 23:59:59'];
        }
        if($keyword){
            $where[] = ['username|nickname','like', "%{$keyword}%"];
        }
        $count  = Db::name('login_log')->alias('l')->where($where)->count();
        $lists  = Db::name('login_log')
            ->alias('l')
            ->leftJoin('user u','l.userid = u.id')
            ->where($where)
            ->field('l.ip,l.create_time,u.username,u.nickname')
            ->limit(($page-1), $limit)
            ->order('l.create_time','desc')
            ->select();
        return Collection::make(['count'=>$count,'lists'=>$lists]);
    }

}