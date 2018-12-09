<?php
/**
 * 后台管理菜单配置
 * Date: 2018/10/3
 * Time: 20:47
 */
namespace Admin\Config;

use Common\Models\System\AdminAction;

class AdminMenuConfig
{
    const MENU_MANAGE_CENTER = 'manage.center';
    const MENU_MANAGE_GROUP = 'manage.group';
    const MENU_MANAGE_ROLE = 'manage.role';
    const MENU_MANAGE_OWNER = 'manage.owner';
    const MENU_MANAGE_AUTHORITY = 'manage.authority';
    const MENU_MANAGE_LOG = 'manage.log';
    const MENU_CULTIVATE_CENTER = 'manage.cultivate';
    const MENU_CULTIVATE_AGENCY = 'manage.agency';

    public static function getMenuName($menuTag)
    {
        if (empty($menuTag)) {
            return '';
        }
        $menus = self::menuMap();
        if (array_key_exists($menuTag, $menus)) {
            return $menus[$menuTag];
        }
//        $menu = AdminAction::where(['name' => $menuTag])->first();
//        if (!empty($menu)) {
//            return $menu->name;
//        }
        return '';
    }

    public static function menuMap()
    {
        return [
            self::MENU_MANAGE_CENTER    =>  '权限中心',
            self::MENU_MANAGE_AUTHORITY =>  '权限管理',
            self::MENU_MANAGE_GROUP     =>  '分组管理',
            self::MENU_MANAGE_ROLE      =>  '角色管理',
            self::MENU_MANAGE_OWNER     =>  '管理员管理',
            self::MENU_MANAGE_LOG       =>  '日志管理',
            RouteConfig::ROUTE_AUTHORITY_LIST       =>  '权限列表',
            RouteConfig::ROUTE_AUTHORITY_CREATE     =>  '权限创建',
            RouteConfig::ROUTE_AUTHORITY_EDIT       =>  '权限编辑',
            RouteConfig::ROUTE_GROUP_LIST       =>  '分组列表',
            RouteConfig::ROUTE_GROUP_CREATE     =>  '创建分组',
            RouteConfig::ROUTE_GROUP_EDIT       =>  '编辑分组',
            RouteConfig::ROUTE_ROLE_LIST       =>  '角色列表',
            RouteConfig::ROUTE_ROLE_CREATE     =>  '创建角色',
            RouteConfig::ROUTE_ROLE_EDIT       =>  '编辑角色',
            RouteConfig::ROUTE_OWNER_LIST       =>  '管理员列表',
            RouteConfig::ROUTE_OWNER_CREATE     =>  '创建管理员',
            RouteConfig::ROUTE_OWNER_EDIT       =>  '编辑管理员',
            RouteConfig::ROUTE_OWNER_AUTHORITY      =>  '编辑管理员权限',
            RouteConfig::ROUTE_ADMIN_LOG_LIST       =>  '系统日志',
            RouteConfig::ROUTE_OPERATE_LOG_LIST     =>  '业务日志',
            self::MENU_CULTIVATE_CENTER            =>  '培训中心',
            self::MENU_CULTIVATE_AGENCY            =>  '机构管理',
            RouteConfig::ROUTE_AGENCY_LIST          =>  '机构列表',
            RouteConfig::ROUTE_AGENCY_CREATE        =>  '创建机构',
            RouteConfig::ROUTE_AGENCY_EDIT          =>  '编辑机构',
            RouteConfig::ROUTE_AGENCY_REMOVE        =>  '作废机构',
        ];
    }
}