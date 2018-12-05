<?php
/**
 * 权限列表
 * Date: 2018/12/1
 * Time: 22:37
 */
namespace App\Http\Admin\Action\System\Authority;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Menu\AdminMenuService;

class IndexAction extends BaseAction
{
    public function run()
    {
        $service = new AuthorityService();
        $list = $service->relateMenu([1,2,3], 1);
        $result = [
            'list'  =>  $list,
            'menu'  =>  $this->initViewMenu(),
        ];
        return $this->createView(ViewConfig::AUTHORITY_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_MANAGE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_MANAGE_AUTHORITY, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_AUTHORITY_LIST, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }
}