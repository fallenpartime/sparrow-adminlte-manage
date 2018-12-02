<?php
/**
 * 后台管理菜单配置
 * Date: 2018/10/3
 * Time: 20:47
 */
namespace Admin\Config;

class AdminMenuConfig
{
    public static function menuList()
    {
        return [
            'manageCenter'  =>  [
                'ownerManage'       =>  '',
                'groupManage'       =>  '',
                'roleManage'        =>  '',
                'authorityManage'   =>  '',
                'logManage'         =>  '',
            ],
        ];
    }

    public static function children()
    {
        return [
            'manageCenter'  =>  [
                'ownerManage'   =>  [
                    'owners'            =>  route('owners'),
                    'ownerInfo'         =>  route('ownerInfo')
                ],
                'groupManage'   =>  [
                    'groups'            =>  route('groups'),
                    'groupInfo'         =>  route('groupInfo')
                ],
                'roleManage'   =>  [
                    'roles'             =>  route('roles'),
                    'roleInfo'          =>  route('roleInfo')
                ],
                'authorityManage'   =>  [
                    'authorities'       =>  route('authorities'),
                    'authorityInfo'     =>  route('authorityInfo')
                ],
                'logManage'     =>  [
                    'operateLogs'       =>  route('operateLogs'),
                    'adminLogs'         =>  route('adminLogs')
                ],
            ],
        ];
    }
}