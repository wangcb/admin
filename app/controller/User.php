<?php

namespace app\controller;
use app\BaseController;
use app\constants\ErrorCode;
use app\model\Transaction;
use app\validate\UserValidate;
use think\Collection;
use think\facade\Db;
use app\model\User as Users;

/**
 * Class User
 * @package app\controller
 */
class User extends BaseController
{
    /**
     * 创建用户
     */
    public function create()
    {
        $param = $this->request->param();
        if (isset($param['password']) && empty($param['password'])){
            unset($param['password']);
        }
        $this->validate($param, UserValidate::class . '.' . $this->request->action());
        if(isset($param['password'])) $param['password'] = password($param['password']);
        $res = Users::create($param);
        return $res;
    }

    /**
     * 修改用户
     * @return array|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundExceptionx
     */
    public function edit()
    {
        $param = $this->request->param();
        if (isset($param['password']) && empty($param['password'])){
            unset($param['password']);
        }
        $this->validate($param, UserValidate::class . '.edit');
        if(isset($param['password'])) $param['password'] = password($param['password']);
        unset($param['username']);
        $res = Users::update($param);
        return $res;
    }

    /**
     * 修改用户
     * @return array|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundExceptionx
     */
    public function password()
    {
        $param = $this->request->param();
        $password = Users::where('id', $this->user->id)->value('password');
        if ($password != password($param['opassword'])) {
            $this->error(ErrorCode::OPASSWORD_INVAL);
        }

        $this->validate($param, UserValidate::class . '.' . $this->request->action());
        $param['id'] = $this->user->id;
        $param['password'] = password($param['password']);
        $res = Users::update($param);
        return $res;
    }

    /**
     * 用户状态
     */
    public function state()
    {
        $param = $this->request->param();
        $this->validate($param, UserValidate::class . '.' . $this->request->action());
        $res = Users::update($param);
        return $res;
    }
	/**
	 * 改变余额
	 */
	public function change(){
		$id = $this->request->param('id','','intval');
		$resOne = Db::name('user')->where('id',$id)->find();
		if(!empty($resOne)){
			$param = $this->request->param();
			if($param['changeType'] == '-'){
				//判断金额
				if($param['money']>$resOne['credit']){
					$this->error(500,'减少的余额最大：'.$resOne['credit']);
				}
				$res = Db::name('user')->where('id',$id)->dec('credit', $param['money'])->update();
			}else if($param['changeType'] == '+'){
				$res = Db::name('user')->where('id',$id)->inc('credit', $param['money'])->update();
			}
			if($res){
				//财务记录
				Db::name('transaction')->insert([
					'userid'=>$id,
					'order_no'=>order_no(),
					'money'=>$param['changeType'].$param['money'],
					'status'=>1,
					'title'=>'手工充值',
					'type'=>1,
					'create_time'=>date('Y-m-d H:i:s'),
				]);
			}
			return $res;
		}else{
			$this->error(500,'ID不存在');
		}
	}
	

    /**
     * 列表
     */
    public function lists()
    {
        $page = $this->request->param('page', 1);
        $limit = $this->request->param('limit', 10);
        $keyword = $this->request->param('keyword', '');
        $sex = $this->request->param('sex', '');
        $where = [];
        if ($keyword) $where[] = ['username|nickname|mobile', 'like', "%{$keyword}%"];
        if (is_numeric($sex)) $where[] = ['sex', '=', $sex];

        $count = Users::where($where)->count();
        $users = Users::where($where)->limit(($page - 1), $limit)->select();
        foreach ($users as $user) {
            $user->roles = $user->getRoles();
        }
        return Collection::make(['count' => $count, 'lists' => $users]);
    }

    /**
     * 详情
     * @param $id
     * @return array|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function detail($id)
    {
        $id = $id ? $id : $this->user->id;
        $detail = Users::find($id);
		$detail->base64 = empty($detail->avatar) ? '' : img2Base64($detail->avatar);
        $detail->roles = $detail->getRoles();
        $permission = $detail->getAllPermissions();
        $authorities = [];
        foreach ($permission as $v) {
            if ($v['name']) $authorities[] = $v['name'];
        }
        $detail->authorities = $authorities;
        return $detail;
    }

	/*public function getAvatarBase64()
	{
		$detail = Users::find($this->user->id);
		return img2Base64($detail['avatar']);
	}*/

    /**
     * 删除
     */
    public function delete()
    {
        $id = $this->request->param('id');
        $res = Users::destroy($id);
        return $res;
    }

    /**
     * 菜单
     * @return mixed
     */
    public function menu()
    {
        $res = $this->user->getAllPermissions();
        return $res;
    }

    /**
     * 流水
     */
    public function transaction()
    {
        $page = $this->request->param('page', 1);
        $limit = $this->request->param('limit', 10);
        $state = $this->request->param('state', '');
        $where = [
            ['userid', '=', $this->user->id]
        ];
        if (is_numeric($state)) {
            $where[] = ['status', '=', $state];
        }
        $count = Transaction::where($where)->count();
        $lists = Transaction::where($where)
            ->limit(($page - 1), $limit)
            ->order('create_time', 'desc')
            ->select();
        return Collection::make(['count' => $count, 'lists' => $lists]);
    }
}