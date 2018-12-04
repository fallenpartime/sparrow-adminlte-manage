<?php
/**
 * 管理员权限配置
 * Date: 2018/12/4
 * Time: 20:37
 */
namespace App\Http\Admin\Action\System\Owner;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Integration\OwnerAuthoritiesIntegration;
use Admin\Services\Authority\Integration\OwnerCustomAuthorityIntegration;
use Admin\Services\Authority\Integration\RelateAuthoritiesCheckedIntegration;
use Admin\Services\Owner\Integration\OwnerAuthorityIntegration;
use Common\Models\System\AdminUserInfo;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class AuthorityAction extends BaseAction
{
    use ApiActionTrait;

    protected $_user = null;
    protected $_owner = null;
    protected $_role = null;
    protected $_userAction = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_owner = AdminUserInfo::with(['user', 'role', 'userAction'])->find($id);
            if (!empty($this->_owner)) {
                $this->_user = $this->_owner->user;
                $this->_role = $this->_owner->role;
                $this->_userAction = $this->_owner->userAction;
            }
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        if (empty($this->_owner)) {
            header('Location: '.route(RouteConfig::ROUTE_OWNER_LIST));
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $service = new AuthorityService();
        $authorities = $service->relateMenu();
        $authorities = $this->parseUserMenu($authorities);
        $result = [
            'record'            =>  $this->_owner,
            'user'              =>  $this->_user,
            'authorities'       =>  $authorities,
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_OWNER_LIST), 'url' => route(RouteConfig::ROUTE_OWNER_LIST), 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_OWNER_AUTHORITY), 'url' => '', 'active' => 1],
            ],
            'actionUrl'         => route(RouteConfig::ROUTE_OWNER_AUTHORITY),
            'redirectUrl'       => route(RouteConfig::ROUTE_OWNER_LIST),
        ];
        return $this->createView(ViewConfig::OWNER_AUTHORITY, $result);
    }

    protected function parseUserMenu($menus)
    {
        list($stauts, $message, $userActions) = (new OwnerAuthoritiesIntegration($this->_owner))->process();
        if (!empty($userActions)) {
            list($status, $count, $menus) = (new RelateAuthoritiesCheckedIntegration($menus, $userActions))->process();
        }
        return $menus;
    }

    protected function getRoleActions()
    {
        $roleActions = [];
        if (!empty($this->_role) && !empty($this->_role->actions)) {
            $roleActions = json_decode($this->_role->actions, true);
        }
        return $roleActions;
    }

    protected function process()
    {
        $authList = $this->request->get('auth_checked');
        if (empty($authList)) {
            $this->errorJson(500, '权限为空');
        }
        list($status, $message, $data) = (new OwnerCustomAuthorityIntegration($this->_owner, $authList))->process();
        if ($status) {
            list($status, $message) = (new OwnerAuthorityIntegration($this->request, $this->_owner, $data))->process();
            if ($status) {
                $this->successJson();
            }
        }
        $this->errorJson(500, $message);
    }
}