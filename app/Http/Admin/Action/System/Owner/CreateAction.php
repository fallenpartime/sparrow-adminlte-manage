<?php
/**
 * 管理员创建
 * Date: 2018/12/1
 * Time: 22:38
 */
namespace App\Http\Admin\Action\System\Owner;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\Processor\AdminUserInfoProcessor;
use Admin\Services\Authority\Processor\AdminUserProcessor;
use Common\Models\System\AdminUserRole;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class CreateAction extends BaseAction
{
    use ApiActionTrait;

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
        $result = [
            'roles' =>  AdminUserRole::all(),
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_OWNER_LIST), 'url' => route(RouteConfig::ROUTE_OWNER_LIST), 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_OWNER_CREATE), 'url' => '', 'active' => 1],
            ],
            'actionUrl'         => route(RouteConfig::ROUTE_OWNER_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_OWNER_LIST),
        ];
        return $this->createView(ViewConfig::OWNER_CREATE, $result);
    }

    protected function validateRepeat(AdminUserProcessor $processor, $data)
    {
        $record = $processor->getSingleByName($data['name']);
        if (!empty($record)) {
            $this->errorJson(500, '后台用户名已存在');
        }
        $record = $processor->getSingleByPhone($data['phone']);
        if (!empty($record)) {
            $this->errorJson(500, '后台用户电话已存在');
        }
        return [true, 0, ''];
    }

    protected function changPassword($pwd, $data)
    {
        $salt   =   md5(rand());
        $md5pwd =   md5($salt . $pwd);
        $data['pwd']    =   $md5pwd;
        $data['salt']   =   $salt;
        return $data;
    }

    protected function initOwnerData()
    {
        $httpTool = $this->getHttpTool();
        $params = $httpTool->getParams();
        $username = $httpTool->getBothSafeParam('name');
        $phone = $httpTool->getBothSafeParam('phone');
        $pwd = $httpTool->getBothSafeParam('pwd');
        $roleId = $httpTool->getBothSafeParam('role_id', HttpConfig::PARAM_NUMBER_TYPE);
        $isAdmin = $httpTool->getBothSafeParam('is_admin', HttpConfig::PARAM_NUMBER_TYPE);
        $username = trim($username);
        $phone = trim($phone);
        $ownerData = [
            'role_id'   =>  !empty($roleId)? $roleId: 0,
            'is_owner'  =>  1,
            'is_admin'  =>  !empty($isAdmin)? $isAdmin: 0,
        ];
        $userData = [
            'name'      =>  $username,
            'phone'     =>  $phone,
        ];
        if (!empty($pwd)) {
            $userData = $this->changPassword($pwd, $userData);
        }
        if (isset($params['is_super'])) {
            $isSuper = $httpTool->getBothSafeParam('is_super', HttpConfig::PARAM_NUMBER_TYPE);
            $ownerData['is_super'] = !empty($isSuper)? $isSuper: 0;
        }
        return [$userData, $ownerData];
    }

    protected function store($userData, $ownerData)
    {
        $adminUserProcessor = new AdminUserProcessor();
        list($res, $errorId, $message) = $this->validateRepeat($adminUserProcessor, $userData);
        if ($res == false) {
            $this->errorJson(500, $message);
        }
        list($status, $user) = $adminUserProcessor->insert($userData);
        if (empty($user)) {
            $this->errorJson(500, '后台用户基本信息创建失败');
        }
        $ownerData['user_id'] = $user->id;
        $userInfoProcessor = new AdminUserInfoProcessor();
        list($status, $userInfo) = $userInfoProcessor->insert($ownerData);
        if ($status) {
            $this->getLogTool()->adminLog(1, $user->id, '创建管理员');
            $this->successJson();
        }
        $this->errorJson(500, '后台用户信息创建失败');
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $username = $httpTool->getBothSafeParam('name');
        $username = trim($username);
        $phone = $httpTool->getBothSafeParam('phone');
        $phone = trim($phone);
        $roleId = $httpTool->getBothSafeParam('role_id', HttpConfig::PARAM_NUMBER_TYPE);
        $isAdmin = $httpTool->getBothSafeParam('is_admin', HttpConfig::PARAM_NUMBER_TYPE);
        if(empty($username)){
            $this->errorJson(500, '用户名为空');
        }
        if(empty($phone)){
            $this->errorJson(500, '电话不能为空');
        }
        if(empty($roleId) && !empty($isAdmin)){
            $this->errorJson(500, '未配置角色前不允许登录');
        }
        if (!empty($id) && empty($this->_owner)) {
            $this->errorJson(500, '记录不存在');
        }
        list($userData, $ownerData) = $this->initOwnerData();
        $this->store($userData, $ownerData);
    }
}