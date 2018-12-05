<?php
/**
 * 后台配置类
 * Date: 2018/10/5
 * Time: 9:53
 */
namespace Admin\Config;

class AdminConfig
{
    const ADMIN_INFO = 'admin_info';
    const ADMIN_TS_LIST = 'ts_list';

    public static function getAnalogAdminLogin()
    {
        return env('ANALOG_ADMIN_LOGIN', 0);
    }

    public static function indexUrlList()
    {
        return [
            RouteConfig::ROUTE_INDEX            => ['title'=>'首页', 'url'=>route(RouteConfig::ROUTE_INDEX)],
            RouteConfig::ROUTE_OWNER_LIST       => ['title'=>'管理员列表', 'url'=>route(RouteConfig::ROUTE_OWNER_LIST)],
        ];
    }

    public static function getIndexUrl($indexTag, $columnName = 'url', $withDefault = 1)
    {
        $indexUrls = self::indexUrlList();
        if (empty($indexTag)) {
            $indexTag = RouteConfig::ROUTE_INDEX;
        }
        if (!array_key_exists($indexTag, $indexUrls)) {
            $indexTag = RouteConfig::ROUTE_INDEX;
        }
        return $indexUrls[$indexTag][$columnName];
    }

    public static function getAdminOperateList()
    {
        return [
            '1'  => '添加管理员',
            '2'  => '编辑管理员',
            '3'  => '编辑管理员权限',
            '10' => '添加权限',
            '11' => '编辑权限',
            '20' => '添加分组',
            '21' => '编辑分组',
            '30' => '添加角色',
            '31' => '编辑角色',
        ];
    }

    public static function getOperateList()
    {
        return [
//            '1'  => '添加文章',
//            '2'  => '编辑文章',
//            '3'  => '作废文章',
//            '4'  => '文章显示状态修改',
//            '5'  => '文章缓存刷新',
//            '20' => '添加活动',
//            '21' => '编辑活动',
//            '22' => '活动开放状态修改',
//            '23' => '活动作废',
//            '24' => '活动显示状态修改',
//            '25' => '活动缓存刷新',
//            '40' => '添加问题',
//            '41' => '编辑问题',
//            '42' => '作废问题',
//            '43' => '问题显示状态修改',
//            '50' => '用户意见作废',
//            '51' => '用户意见答复',
//            '52' => '用户意见显示状态修改',
//            '60' => '添加学校',
//            '61' => '编辑学校',
//            '62' => '学校显示状态修改',
//            '70' => '添加学区',
//            '71' => '编辑学区',
//            '72' => '学区显示状态修改',
        ];
    }
}
