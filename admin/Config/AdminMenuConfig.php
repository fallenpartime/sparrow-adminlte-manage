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
    const MENU_CULTIVATE_TEACHER = 'manage.teacher';
    const MENU_CULTIVATE_LEVEL = 'manage.level';
    const MENU_CULTIVATE_MAJOR = 'manage.major';
    const MENU_CULTIVATE_MAJOR_COURSE = 'manage.major.course';
    const MENU_CULTIVATE_COURSE = 'manage.course';
    const MENU_CULTIVATE_COURSE_TEACHER = 'manage.course.teacher';
    const MENU_CULTIVATE_COURSE_PRICE = 'manage.course.price';
    const MENU_SPREAD = 'manage.spread';
    const MENU_SPREAD_ARTICLE = 'manage.spread.article';
    const MENU_USER_CENTER = 'manage.user.center';
    const MENU_USER = 'manage.user';
    const MENU_USER_APPLY = 'manage.user.apply';
    const MENU_TRADE = 'manage.trade';
    const MENU_TRADE_ORDER = 'manage.trade.order';

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
            self::MENU_CULTIVATE_TEACHER           =>  '教师管理',
            RouteConfig::ROUTE_TEACHER_LIST         =>  '教师列表',
            RouteConfig::ROUTE_TEACHER_CREATE       =>  '创建教师',
            RouteConfig::ROUTE_TEACHER_EDIT         =>  '编辑教师',
            self::MENU_CULTIVATE_LEVEL             =>  '培训等级管理',
            RouteConfig::ROUTE_LEVEL_LIST           =>  '培训等级列表',
            RouteConfig::ROUTE_LEVEL_CREATE         =>  '创建培训等级',
            RouteConfig::ROUTE_LEVEL_EDIT           =>  '编辑培训等级',
            self::MENU_CULTIVATE_MAJOR             =>  '培训专业管理',
            RouteConfig::ROUTE_MAJOR_LIST          =>  '培训专业列表',
            RouteConfig::ROUTE_MAJOR_CREATE         =>  '创建培训专业',
            RouteConfig::ROUTE_MAJOR_EDIT           =>  '编辑培训专业',
            self::MENU_CULTIVATE_MAJOR_COURSE       =>  '培训专业管理',
            RouteConfig::ROUTE_MAJOR_COURSE_LIST    =>  '专业课程列表',
            RouteConfig::ROUTE_MAJOR_COURSE_CREATE  =>  '创建专业课程',
            RouteConfig::ROUTE_MAJOR_COURSE_EDIT    =>  '编辑专业课程',
            self::MENU_CULTIVATE_COURSE             =>  '开班管理',
            RouteConfig::ROUTE_COURSE_LIST          =>  '专业开班列表',
            RouteConfig::ROUTE_COURSE_CREATE        =>  '创建开班',
            RouteConfig::ROUTE_COURSE_REMOVE        =>  '编辑开班',
            self::MENU_CULTIVATE_COURSE_TEACHER         =>  '开班教师管理',
            RouteConfig::ROUTE_COURSE_TEACHER_LIST      =>  '开班教师列表',
            RouteConfig::ROUTE_COURSE_TEACHER_CREATE    =>  '创建开班教师',
            RouteConfig::ROUTE_COURSE_TEACHER_EDIT    =>  '编辑开班教师',
            self::MENU_CULTIVATE_COURSE_PRICE           =>  '开班报价管理',
            RouteConfig::ROUTE_COURSE_PRICE_LIST        =>  '开班报价列表',
            RouteConfig::ROUTE_COURSE_PRICE_CREATE      =>  '创建开班报价',
            self::MENU_SPREAD                           =>  '推广中心',
            self::MENU_SPREAD_ARTICLE                   =>  '文章管理',
            RouteConfig::ROUTE_SPREAD_ARTICLE_LIST      =>  '文章列表',
            RouteConfig::ROUTE_SPREAD_ARTICLE_CREATE    =>  '创建文章',
            RouteConfig::ROUTE_SPREAD_ARTICLE_EDIT      =>  '编辑文章',
            self::MENU_USER_CENTER                      =>  '用户中心',
            self::MENU_USER                             =>  '用户管理',
            RouteConfig::ROUTE_USER_LIST                =>  '用户列表',
            self::MENU_USER_APPLY                       =>  '用户申请管理',
            RouteConfig::ROUTE_USER_APPLY_LIST          =>  '用户申请列表',
            self::MENU_TRADE                            =>  '交易中心',
            self::MENU_TRADE_ORDER                      =>  '订单管理',
            RouteConfig::ROUTE_TRADE_ORDER_LIST         =>  '订单列表',
        ];
    }

}