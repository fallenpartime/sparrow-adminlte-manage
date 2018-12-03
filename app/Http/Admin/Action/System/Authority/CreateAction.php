<?php
/**
 * 权限创建
 * Date: 2018/12/1
 * Time: 22:38
 */
namespace App\Http\Admin\Action\System\Group;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\AuthorityService;
use Frameworks\Tool\Http\Config\HttpConfig;

class CreateAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $authorityService = new AuthorityService();
        $result = [
            'relate_menu'   => $authorityService->relateMenu([1,2]),
            'menu'  =>  [
                AdminMenuConfig::MENU_MANAGE_CENTER => ['tag' => AdminMenuConfig::MENU_MANAGE_CENTER, 'title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                AdminMenuConfig::MENU_MANAGE_AUTHORITY => ['tag' => AdminMenuConfig::MENU_MANAGE_AUTHORITY, 'title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                RouteConfig::ROUTE_AUTHORITY_CREATE => ['tag' => RouteConfig::ROUTE_AUTHORITY_CREATE, 'title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_AUTHORITY_CREATE), 'url' => '', 'active' => 1],
            ],
            'actionUrl'     => route(RouteConfig::ROUTE_AUTHORITY_CREATE),
            'redirectUrl'   => route(RouteConfig::ROUTE_AUTHORITY_LIST),
        ];
        return $this->createView(ViewConfig::AUTHORITY_CREATE, $result);
    }

    protected function process()
    {

    }
}