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
use Admin\Services\Menu\AdminMenuService;
use Common\Models\System\AdminUserGroup;

class IndexAction extends BaseAction
{
    public function run()
    {
        $list = AdminUserGroup::all();
        $result = [
            'list'  =>  $list,
            'menu'  =>  $this->initViewMenu(),
        ];
        return $this->createView(ViewConfig::GROUP_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_MANAGE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_MANAGE_GROUP, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_GROUP_LIST, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }
}