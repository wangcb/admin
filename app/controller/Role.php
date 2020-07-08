<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/15
 * Time: 16:07
 */

namespace app\controller;


use app\BaseController;
use app\constants\ErrorCode;
use app\validate\RoleValidate;
use think\Collection;
use wangcb\permission\Models\Roles;

class Role extends BaseController
{

    /**
     * 创建角色
     */
    public function create(){
        $param = $this->request->param();
        $this->validate($param,RoleValidate::class.'.'.$this->request->action());
        $res = Roles::create($param);
        return $res;
    }

    public function edit(){
        $param = $this->request->param();
        $this->validate($param,RoleValidate::class.'.'.$this->request->action());
        $res = Roles::update($param);
        return $res;
    }

    /**
     * 列表
     */
    public function lists(){
        $keyowrd = $this->request->param('keyowrd');
        $map = [
            ['name|description','like', "%{$keyowrd}%"]
        ];
        $count = Roles::where($map)->count();
        $roles = Roles::where($map)->select();
        return Collection::make(['count'=>$count,'lists'=>$roles]);
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
        $res = Roles::destroy($id);
        return $res;
    }

    /**
     * 授权
     */
    public function permission(){
        $role_id    = $this->request->param('role_id');
        $permission_id = $this->request->param('permission_id');
        $role = Roles::find($role_id);
        $res = $role->permission($permission_id ? explode(',',$permission_id) : []);
        if ($res === false){
            $this->error(ErrorCode::INSERT_FAILED);
        }
        return $res;
    }

    /**
     * 获取角色权限
     * @return array|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function menu(){
        $role_id    = $this->request->param('role_id');
        $Role = new Roles();
        $res = $Role->menu($role_id);
        return $res;
    }

    public function users(){
        $model  = $this->request->param('model');
        $Role   = new Roles();
        $res    = $Role->users($model ? 14 : 13);
        return $res;
    }


}