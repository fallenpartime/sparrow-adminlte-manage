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

    public static function getMenuName($menuTag)
    {
        if (empty($menuTag)) {
            return '';
        }
        $menu = AdminAction::where(['name' => $menuTag])->first();
        if (!empty($menu)) {
            return $menu->name;
        }
        return '';
    }

//    public static function menuMap()
//    {
//        return [
//            self::MENU_MANAGE_CENTER    =>  '权限中心',
//            self::MENU_MANAGE_AUTHORITY =>  '权限管理',
//            self::MENU_MANAGE_GROUP     =>  '分组管理',
//            self::MENU_MANAGE_ROLE      =>  '角色管理',
//            self::MENU_MANAGE_OWNER     =>  '管理员管理',
//            self::MENU_MANAGE_LOG       =>  '日志管理',
//            RouteConfig::ROUTE_AUTHORITY_LIST       =>  '权限列表',
//            RouteConfig::ROUTE_AUTHORITY_CREATE     =>  '权限创建',
//            RouteConfig::ROUTE_AUTHORITY_EDIT       =>  '权限编辑',
//            RouteConfig::ROUTE_GROUP_LIST       =>  '分组列表',
//            RouteConfig::ROUTE_GROUP_CREATE     =>  '分组创建',
//            RouteConfig::ROUTE_GROUP_EDIT       =>  '分组编辑',
//            RouteConfig::ROUTE_ROLE_LIST       =>  '角色列表',
//            RouteConfig::ROUTE_ROLE_CREATE     =>  '角色创建',
//            RouteConfig::ROUTE_ROLE_EDIT       =>  '角色编辑',
//            RouteConfig::ROUTE_OWNER_LIST       =>  '管理员列表',
//            RouteConfig::ROUTE_OWNER_CREATE     =>  '管理员创建',
//            RouteConfig::ROUTE_OWNER_EDIT       =>  '管理员编辑',
//        ];
//    }

    public static function menuList()
    {
        return [
            self::MENU_MANAGE_CENTER  =>  [
                self::MENU_MANAGE_OWNER         =>  '',
                self::MENU_MANAGE_GROUP         =>  '',
                self::MENU_MANAGE_ROLE          =>  '',
                self::MENU_MANAGE_AUTHORITY     =>  '',
                self::MENU_MANAGE_LOG           =>  '',
            ],
        ];
    }

    public static function children()
    {
        return [
            self::MENU_MANAGE_CENTER  =>  [
                self::MENU_MANAGE_OWNER         =>  [
                    RouteConfig::ROUTE_OWNER_LIST       =>  route(RouteConfig::ROUTE_OWNER_LIST),
                    RouteConfig::ROUTE_OWNER_CREATE     =>  route(RouteConfig::ROUTE_OWNER_CREATE)
                ],
                self::MENU_MANAGE_GROUP         =>  [
                    RouteConfig::ROUTE_GROUP_LIST       =>  route(RouteConfig::ROUTE_GROUP_LIST),
                    RouteConfig::ROUTE_GROUP_CREATE     =>  route(RouteConfig::ROUTE_GROUP_CREATE)
                ],
                self::MENU_MANAGE_ROLE   =>  [
                    RouteConfig::ROUTE_ROLE_LIST        =>  route(RouteConfig::ROUTE_ROLE_LIST),
                    RouteConfig::ROUTE_ROLE_CREATE      =>  route(RouteConfig::ROUTE_ROLE_CREATE)
                ],
                self::MENU_MANAGE_AUTHORITY     =>  [
                    RouteConfig::ROUTE_AUTHORITY_LIST       =>  route(RouteConfig::ROUTE_AUTHORITY_LIST),
                    RouteConfig::ROUTE_AUTHORITY_CREATE     =>  route(RouteConfig::ROUTE_AUTHORITY_CREATE),
                ],
                self::MENU_MANAGE_LOG           =>  [
                    RouteConfig::ROUTE_ADMIN_LOG_LIST       =>  route(RouteConfig::ROUTE_ADMIN_LOG_LIST),
                    RouteConfig::ROUTE_OPERATE_LOG_LIST     =>  route(RouteConfig::ROUTE_OPERATE_LOG_LIST),
                ],
            ],
        ];
    }
}