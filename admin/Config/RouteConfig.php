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
    // 培训中心.机构
    const ROUTE_AGENCY_LIST = 'admin.cultivate.agency';
    const ROUTE_AGENCY_CREATE = 'admin.cultivate.agency.create';
    const ROUTE_AGENCY_EDIT = 'admin.cultivate.agency.edit';
    const ROUTE_AGENCY_REMOVE = 'admin.cultivate.agency.remove';
    // 培训中心.教师
    const ROUTE_TEACHER_LIST = 'admin.cultivate.teacher';
    const ROUTE_TEACHER_CREATE = 'admin.cultivate.teacher.create';
    const ROUTE_TEACHER_EDIT = 'admin.cultivate.teacher.edit';
    const ROUTE_TEACHER_REMOVE = 'admin.cultivate.teacher.remove';
    // 培训中心.等级
    const ROUTE_LEVEL_LIST = 'admin.cultivate.level';
    const ROUTE_LEVEL_CREATE = 'admin.cultivate.level.create';
    const ROUTE_LEVEL_EDIT = 'admin.cultivate.level.edit';
    // 培训中心.专业
    const ROUTE_MAJOR_LIST = 'admin.cultivate.major';
    const ROUTE_MAJOR_CREATE = 'admin.cultivate.major.create';
    const ROUTE_MAJOR_EDIT = 'admin.cultivate.major.edit';
    const ROUTE_MAJOR_REMOVE = 'admin.cultivate.major.remove';
    // 培训中心.专业.课程
    const ROUTE_MAJOR_COURSE_LIST = 'admin.cultivate.major.course';
    const ROUTE_MAJOR_COURSE_CREATE = 'admin.cultivate.major.course.create';
    const ROUTE_MAJOR_COURSE_EDIT = 'admin.cultivate.major.course.edit';
    const ROUTE_MAJOR_COURSE_REMOVE = 'admin.cultivate.major.course.remove';
}