<?php
/**
 * 路由配置
 * Date: 2018/12/3
 * Time: 12:04
 */
namespace Admin\Config;

class RouteConfig
{
    const ROUTE_WARN = 'admin.warn';
    const ROUTE_LOGIN = 'admin.login';
    const ROUTE_INDEX = 'admin.index';
    const ROUTE_CHECK = 'admin.check';
    const ROUTE_AUTHORITY_LIST = 'admin.system.authority';
    const ROUTE_AUTHORITY_CREATE = 'admin.system.authority.create';
    const ROUTE_AUTHORITY_EDIT = 'admin.system.authority.edit';
    const ROUTE_GROUP_LIST = 'admin.system.group';
    const ROUTE_GROUP_CREATE = 'admin.system.group.create';
    const ROUTE_GROUP_EDIT = 'admin.system.group.edit';
    const ROUTE_ROLE_LIST = 'admin.system.role';
    const ROUTE_ROLE_CREATE = 'admin.system.role.create';
    const ROUTE_ROLE_EDIT = 'admin.system.role.edit';
    const ROUTE_OWNER_LIST = 'admin.system.owner';
    const ROUTE_OWNER_CREATE = 'admin.system.owner.create';
    const ROUTE_OWNER_EDIT = 'admin.system.owner.edit';
    const ROUTE_OWNER_AUTHORITY = 'admin.system.owner.authority';
    const ROUTE_ADMIN_LOG_LIST = 'admin.system.admin.log';
    const ROUTE_OPERATE_LOG_LIST = 'admin.system.operate.log';
}