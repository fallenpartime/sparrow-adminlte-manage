<?php
/**
 * 模板配置
 * Date: 2018/12/3
 * Time: 12:07
 */
namespace Admin\Config;

class ViewConfig
{
    const LOGIN_QRCODE = 'admin.basic.login.qrcode';
    const LOGIN_PASSWORD = 'admin.basic.login.password';
    // 权限
    const AUTHORITY_LIST = 'admin.system.authority.index';
    const AUTHORITY_CREATE = 'admin.system.authority.create';
    const AUTHORITY_EDIT = 'admin.system.authority.edit';
    // 日志
    const LOG_ADMIN_LIST = 'admin.system.log.admin';
    const LOG_OPERATE_LIST = 'admin.system.log.operate';
    // 分组
    const GROUP_LIST = 'admin.system.group.index';
    const GROUP_CREATE = 'admin.system.group.create';
    const GROUP_EDIT = 'admin.system.group.edit';
}