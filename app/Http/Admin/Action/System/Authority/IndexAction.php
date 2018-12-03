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

class IndexAction extends BaseAction
{
    public function run()
    {
        $service = new AuthorityService();
        $list = $service->relateMenu([1,2,3], 1);
        $result = [
            'list'  =>  $list,
            'menu'  =>  [
                AdminMenuConfig::MENU_MANAGE_CENTER => ['tag' => AdminMenuConfig::MENU_MANAGE_CENTER, 'title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                AdminMenuConfig::MENU_MANAGE_AUTHORITY => ['tag' => AdminMenuConfig::MENU_MANAGE_AUTHORITY, 'title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                RouteConfig::ROUTE_AUTHORITY_LIST => ['tag' => RouteConfig::ROUTE_AUTHORITY_LIST, 'title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_AUTHORITY_LIST), 'url' => '', 'active' => 1],
            ],
        ];
        return $this->createView(ViewConfig::AUTHORITY_LIST, $result);
    }
}