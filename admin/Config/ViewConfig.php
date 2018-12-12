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
    // 培训等级
    const LEVEL_LIST = 'admin.cultivate.level.index';
    const LEVEL_CREATE = 'admin.cultivate.level.create';
    const LEVEL_EDIT = 'admin.cultivate.level.edit';
    // 培训专业
    const MAJOR_LIST = 'admin.cultivate.major.index';
    const MAJOR_CREATE = 'admin.cultivate.major.create';
    const MAJOR_EDIT = 'admin.cultivate.major.edit';
    // 培训专业.课程
    const MAJOR_COURSE_LIST = 'admin.cultivate.major.course.index';
    const MAJOR_COURSE_CREATE = 'admin.cultivate.major.course.create';
    const MAJOR_COURSE_EDIT = 'admin.cultivate.major.course.edit';
    // 培训专业.开班
    const COURSE_LIST = 'admin.cultivate.course.index';
    const COURSE_CREATE = 'admin.cultivate.course.create';
    const COURSE_EDIT = 'admin.cultivate.course.edit';
    // 培训专业.开班.教师
    const COURSE_TEACHER_LIST = 'admin.cultivate.course.teacher.index';
    const COURSE_TEACHER_CREATE = 'admin.cultivate.course.teacher.create';
    const COURSE_TEACHER_EDIT = 'admin.cultivate.course.teacher.edit';
    // 培训专业.开班.报价
    const COURSE_PRICE_LIST = 'admin.cultivate.price.index';
    const COURSE_PRICE_CREATE = 'admin.cultivate.price.create';
    const COURSE_PRICE_EDIT = 'admin.cultivate.price.edit';
}