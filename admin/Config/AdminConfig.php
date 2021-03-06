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
            RouteConfig::ROUTE_AGENCY_LIST       => ['title'=>'机构列表', 'url'=>route(RouteConfig::ROUTE_AGENCY_LIST)],
            RouteConfig::ROUTE_OWNER_LIST       => ['title'=>'管理员列表', 'url'=>route(RouteConfig::ROUTE_OWNER_LIST)],
            RouteConfig::ROUTE_SPREAD_ARTICLE_LIST      => ['title'=>'文章列表', 'url'=>route(RouteConfig::ROUTE_SPREAD_ARTICLE_LIST)],
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
            '1'     => '添加机构',
            '2'     => '编辑机构',
            '3'     => '作废机构',
            '10'    => '添加教师',
            '11'    => '编辑教师',
            '12'    => '作废教师',
            '20'    => '添加培训等级',
            '21'    => '编辑培训等级',
            '30'    => '添加培训专业',
            '31'    => '编辑培训专业',
            '32'    => '作废培训专业',
            '33'    => '更改培训专业显示状态',
            '40'    => '添加培训专业课程',
            '41'    => '编辑培训专业课程',
            '42'    => '作废培训专业课程',
            '50'    => '添加开班',
            '51'    => '编辑开班',
            '52'    => '作废开班',
            '60'    => '添加开班教师',
            '61'    => '编辑开班教师',
            '62'    => '作废开班教师',
            '70'    => '添加开班报价',
            '71'    => '激活开班报价',
            '80'    => '添加推广文章',
            '81'    => '编辑推广文章',
            '82'    => '作废推广文章',
            '83'    => '推广文章显示状态修改',
            '84'    => '推广文章发布状态修改',
        ];
    }
}
