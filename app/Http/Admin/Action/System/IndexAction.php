<?php
/**
 * 系统登录跳转首页
 * Date: 2018/12/3
 * Time: 10:26
 */
namespace App\Http\Admin\Action\System;

use Admin\Action\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Config\RouteConfig;
use Admin\Services\Authority\Processor\AdminUserRoleProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $admin_info = $this->getAuthService()->getAdminInfo();
        $roleId = $admin_info['role_id'];
        $admin_url = route('admin.login');
        if ($roleId > 0) {
            $role = (new AdminUserRoleProcessor())->getSingleByNo($roleId);
            $indexAction = $role->index_action;
            if (!empty($indexAction)) {
                $admin_url = AdminConfig::getIndexUrl($indexAction, 'url', 0);
            }
        }
        header("location: {$admin_url}");
        exit;
    }
}
