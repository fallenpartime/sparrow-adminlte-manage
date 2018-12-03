<?php
/**
 * 分组列表
 * Date: 2018/12/1
 * Time: 22:37
 */
namespace App\Http\Admin\Action\System\Group;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Common\Models\System\AdminUserGroup;

class IndexAction extends BaseAction
{
    public function run()
    {
        $list = AdminUserGroup::all();
        $result = [
            'list'  =>  $list,
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_GROUP), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_GROUP_LIST), 'url' => '', 'active' => 1],
            ],
        ];
        return $this->createView(ViewConfig::GROUP_LIST, $result);
    }
}