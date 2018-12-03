<?php

use Illuminate\Database\Seeder;

use Admin\Services\Authority\Processor\AdminUserProcessor;
use Admin\Services\Authority\Processor\AdminUserInfoProcessor;
use Admin\Services\Authority\Processor\AdminUserGroupProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Admin\Services\Authority\Processor\AdminActionProcessor;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;

class InitSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 分组信息
        $groupProcessor = new AdminUserGroupProcessor();
        list($status, $group) = $groupProcessor->insert(['group_no'=>1, 'name'=>'管理员', 'tip'=>'administrator']);
        // 角色信息
        $roleProcessor = new AdminUserRoleProcessor();
        list($status, $role) = $roleProcessor->insert(['role_no'=>1, 'name'=>'管理员', 'index_action'=>'owners']);
        // 角色关联信息
        $accessProcessor = new AdminUserRoleAccessProcessor();
        list($status, $access) = $accessProcessor->insert(['group_no'=>$group->group_no, 'role_no'=>$role->role_no]);
        // 用户信息
        $userProcessor = new AdminUserProcessor();
        list($status, $user) = $userProcessor->insert(['name'=>'adminc', 'phone'=>'13212345678', 'pwd'=>'65c21e07a6b79fe43e624e0e853d94dd', 'salt'=>'61d17b104905d7474c4f917627ba7fab']);
        // 用户详情信息
        $userInfoProcessor = new AdminUserInfoProcessor();
        list($status, $userInfo) = $userInfoProcessor->insert(['user_id'=>$user->id, 'role_id'=>$role->role_no, 'is_admin'=>1]);
        $this->initActionList();
    }

    protected function initActionList()
    {
        $list = [
            ['name'=>'权限中心', 'type'=>1, 'action'=>AdminMenuConfig::MENU_MANAGE_CENTER, 'list'=>[
                ['name'=>'管理员管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_MANAGE_OWNER, 'list'=>[
                    ['name'=>'管理员列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_OWNER_LIST],
                    ['name'=>'创建管理员', 'type'=>3, 'action'=>RouteConfig::ROUTE_OWNER_CREATE],
                    ['name'=>'编辑管理员', 'type'=>3, 'action'=>RouteConfig::ROUTE_OWNER_EDIT]
                ]],
                ['name'=>'分组管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_MANAGE_GROUP, 'list'=>[
                    ['name'=>'分组列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_GROUP_LIST],
                    ['name'=>'创建分组', 'type'=>3, 'action'=>RouteConfig::ROUTE_GROUP_CREATE],
                    ['name'=>'编辑分组', 'type'=>3, 'action'=>RouteConfig::ROUTE_GROUP_EDIT]
                ]],
                ['name'=>'角色管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_MANAGE_ROLE, 'list'=>[
                    ['name'=>'角色列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_ROLE_LIST],
                    ['name'=>'创建角色', 'type'=>3, 'action'=>RouteConfig::ROUTE_ROLE_CREATE],
                    ['name'=>'编辑角色', 'type'=>3, 'action'=>RouteConfig::ROUTE_ROLE_EDIT]
                ]],
                ['name'=>'权限管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_MANAGE_AUTHORITY, 'list'=>[
                    ['name'=>'权限列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_AUTHORITY_LIST],
                    ['name'=>'创建权限', 'type'=>3, 'action'=>RouteConfig::ROUTE_AUTHORITY_CREATE],
                    ['name'=>'编辑权限', 'type'=>3, 'action'=>RouteConfig::ROUTE_AUTHORITY_EDIT]
                ]],
                ['name'=>'日志管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_MANAGE_LOG, 'list'=>[
                    ['name'=>'业务日志', 'type'=>3, 'action'=>RouteConfig::ROUTE_OPERATE_LOG_LIST],
                    ['name'=>'系统日志', 'type'=>3, 'action'=>RouteConfig::ROUTE_ADMIN_LOG_LIST],
                ]],
            ]],
        ];
        $actionProcessor = new AdminActionProcessor();
        foreach ($list as $top) {
            $topName = $top['name'];
            $topAction = $top['action'];
            $secondList = $top['list'];
            list($status, $action) = $actionProcessor->insert(['name'=>$topName, 'type'=>1, 'ts_action'=>$topAction]);
            if (!empty($secondList)) {
                $topId = $action->id;
                foreach ($secondList as $second) {
                    $secondName = $second['name'];
                    $secondAction = $second['action'];
                    $operateList = $second['list'];
                    list($status, $action) = $actionProcessor->insert(['name'=>$secondName, 'type'=>2, 'ts_action'=>$secondAction, 'parent_id'=>$topId]);
                    if (!empty($operateList)) {
                        $secondId = $action->id;
                        foreach ($operateList as $operate) {
                            $operateName = $operate['name'];
                            $operateAction = $operate['action'];
                            list($status, $action) = $actionProcessor->insert(['name'=>$operateName, 'type'=>3, 'ts_action'=>$operateAction, 'parent_id'=>$secondId]);
                        }
                    }
                }
            }
        }
    }
}
