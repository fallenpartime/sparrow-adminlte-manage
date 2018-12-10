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
    // 角色
    const ROLE_LIST = 'admin.system.role.index';
    const ROLE_CREATE = 'admin.system.role.create';
    const ROLE_EDIT = 'admin.system.role.edit';
    // 管理员
    const OWNER_LIST = 'admin.system.owner.index';
    const OWNER_CREATE = 'admin.system.owner.create';
    const OWNER_EDIT = 'admin.system.owner.edit';
    const OWNER_AUTHORITY = 'admin.system.owner.authority';
    // 机构
    const AGENCY_LIST = 'admin.school.agency.index';
    const AGENCY_CREATE = 'admin.school.agency.create';
    const AGENCY_EDIT = 'admin.school.agency.edit';
    // 教师
    const TEACHER_LIST = 'admin.school.teacher.index';
    const TEACHER_CREATE = 'admin.school.teacher.create';
    const TEACHER_EDIT = 'admin.school.teacher.edit';
}