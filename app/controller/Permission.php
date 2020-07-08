<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/17
 * Time: 14:59
 */

namespace app\controller;


use app\BaseController;
use app\constants\ErrorCode;
use app\validate\PermissionValidate;
use think\model\Collection;
use wangcb\permission\Models\Permissions;

class Permission extends BaseController
{
    /**
     * 添加
     */
    public function create(){
        $param = $this->request->param();
        $param['guard_name'] = isset($param['guard_name']) ? $param['guard_name'] : 'web';
        $this->validate($param,PermissionValidate::class.'.'.$this->request->action());
        $res = Permissions::create($param);
        return $res;
    }

    /**
     * 添加
     */
    public function edit(){
        $param = $this->request->param();
        $param['guard_name'] = isset($param['guard_name']) ? $param['guard_name'] : 'web';
        $this->validate($param,PermissionValidate::class.'.'.$this->request->action());
        $res = Permissions::update($param);
        return $res;
    }

    /**
     * 列表
     */
    public function lists(){
        $res = Permissions::order('sort','desc')->select();
        return $res;
    }

    /**
     * 详情
     */
    public function detail($id){
        $role = Roles::find($id);
        return $role;
    }

    /**
     * 删除
     */
    public function delete(){
        $id = $this->request->param('id');
        $res = Permissions::destroy($id);
        return $res;
    }
}