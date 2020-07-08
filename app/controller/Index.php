<?php
namespace app\controller;

use app\BaseController;
use think\captcha\facade\Captcha;
use think\facade\Db;
use think\model\Collection;

class Index extends BaseController
{
    protected $isauth = false;

    public function index()
    {
        $uid    = $this->user->id;
        $start  = date('Y-m-d 00:00:00');
        $end    = date('Y-m-d 23:59:59');
        //余额
        $res['credit'] = Db::name('user')->where('id', $uid)->value('credit');

        //收入-今日收入
        $res['in_today']  = Db::name('transaction')
            ->where('userid', $uid)
            ->where('type',2)
            ->where('create_time','>',$start)
            ->where('create_time','<=', $end)
            ->sum('money');

        //收入-总收入
        $res['in_total']  = Db::name('transaction')
            ->where('userid', $uid)
            ->where('type', 2)
            ->sum('money');

        //收入-总订单
        $res['in_total_order'] = Db::name('transaction')
            ->alias('t')
            ->leftJoin('article_media a','a.order_no = t.order_no')
            ->leftJoin('media m','m.id = a.mid')
            ->where('m.userid',$uid)
            ->where(function ($query){
                $query->whereOr('type', 3)->whereOr('type', 5);
            })
            ->group('t.order_no')
            ->count();

        //收入-今日订单
        $res['in_today_order'] = Db::name('transaction')
            ->alias('t')
            ->leftJoin('article_media a','a.order_no = t.order_no')
            ->leftJoin('media m','m.id = a.mid')
            ->where('m.userid',$uid)
            ->where(function ($query){
                $query->whereOr('type', 3)->whereOr('type', 5);
            })
            ->where('t.create_time','>',$start)
            ->where('t.create_time','<=', $end)
            ->group('t.order_no')
            ->count();

        //支出-总订单
        $res['out_total_order'] = Db::name('transaction')
            ->where('userid',$uid)
            ->where(function ($query){
                $query->whereOr('type', 3)->whereOr('type', 5);
            })
            ->group('order_no')
            ->count();

        //支出-今日支出
        $res['out_today'] = -Db::name('transaction')
            ->where('userid',$uid)
            ->where(function ($query){
                $query->whereOr('type', 3)->whereOr('type', 5);
            })
            ->where('create_time','>',$start)
            ->where('create_time','<=', $end)
            ->sum('money');

        //支出-总消费
        $res['out_total'] = -Db::name('transaction')
            ->where('userid',$uid)
            ->where(function ($query){
                $query->whereOr('type', 3)->whereOr('type', 5);
            })
            ->sum('money');

        $res['role'] = $this->user->hasRole(13) || $this->user->hasRole(14);

        return Collection::make($res);
    }

    public function verify(){
        $res =  Captcha::create();
        //file_put_contents('./code.jpg',$res->getContent());
        $type = getimagesizefromstring($res->getContent())['mime'];
        $base64String = 'data:' . $type . ';base64,' . chunk_split(base64_encode($res->getContent()));
        $key = session('captcha.key');
        return Collection::make(['base64'=>$base64String,'key'=>$key]);
    }
}
