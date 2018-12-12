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
        list($status, $role) = $roleProcessor->insert(['role_no'=>1, 'name'=>'管理员', 'index_action'=>'admin.system.owner']);
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
            ['name'=>'培训中心', 'type'=>1, 'action'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'list'=>[
                ['name'=>'机构管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_CULTIVATE_AGENCY, 'list'=>[
                    ['name'=>'机构列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_AGENCY_LIST],
                    ['name'=>'创建机构', 'type'=>3, 'action'=>RouteConfig::ROUTE_AGENCY_CREATE],
                    ['name'=>'编辑机构', 'type'=>3, 'action'=>RouteConfig::ROUTE_AGENCY_EDIT],
                    ['name'=>'作废机构', 'type'=>3, 'action'=>RouteConfig::ROUTE_AGENCY_REMOVE]
                ]],
                ['name'=>'教师管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_CULTIVATE_TEACHER, 'list'=>[
                    ['name'=>'教师列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_TEACHER_LIST],
                    ['name'=>'创建教师', 'type'=>3, 'action'=>RouteConfig::ROUTE_TEACHER_CREATE],
                    ['name'=>'编辑教师', 'type'=>3, 'action'=>RouteConfig::ROUTE_TEACHER_EDIT],
                    ['name'=>'作废教师', 'type'=>3, 'action'=>RouteConfig::ROUTE_TEACHER_REMOVE]
                ]],
                ['name'=>'培训等级管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_CULTIVATE_LEVEL, 'list'=>[
                    ['name'=>'培训等级列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_LEVEL_LIST],
                    ['name'=>'创建培训等级', 'type'=>3, 'action'=>RouteConfig::ROUTE_LEVEL_CREATE],
                    ['name'=>'编辑培训等级', 'type'=>3, 'action'=>RouteConfig::ROUTE_LEVEL_EDIT],
                ]],
                ['name'=>'培训专业管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_CULTIVATE_MAJOR, 'list'=>[
                    ['name'=>'培训专业列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_LIST],
                    ['name'=>'创建培训专业', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_CREATE],
                    ['name'=>'编辑培训专业', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_EDIT],
                    ['name'=>'作废培训专业', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_REMOVE],
                ]],
                ['name'=>'专业课程管理', 'type'=>2, 'action'=>AdminMenuConfig::MENU_CULTIVATE_MAJOR_COURSE, 'list'=>[
                    ['name'=>'专业课程列表', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_COURSE_LIST],
                    ['name'=>'创建专业课程', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_COURSE_CREATE],
                    ['name'=>'编辑专业课程', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_COURSE_EDIT],
                    ['name'=>'作废专业课程', 'type'=>3, 'action'=>RouteConfig::ROUTE_MAJOR_COURSE_REMOVE],
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
