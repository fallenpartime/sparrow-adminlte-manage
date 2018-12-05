<?php
/**
 * 管理员编辑
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
use Admin\Services\Menu\AdminMenuService;
use Common\Models\System\AdminUserInfo;
use Common\Models\System\AdminUserRole;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class EditAction extends BaseAction
{
    use ApiActionTrait;

    protected $user = null;
    protected $owner = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->owner = AdminUserInfo::find($id);
            if (!empty($this->owner)) {
                $this->user = $this->owner->user;
            }
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        if (empty($this->owner)) {
            $this->redirect('管理员不存在', route(RouteConfig::ROUTE_OWNER_LIST));
        }
        $result = [
            'record'            =>  $this->owner,
            'user'              =>  $this->user,
            'roles'             =>  AdminUserRole::all(),
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_OWNER_EDIT),
            'authorityUrl'      => route(RouteConfig::ROUTE_OWNER_AUTHORITY, ['id'=>$this->owner->id]),
            'redirectUrl'       => route(RouteConfig::ROUTE_OWNER_LIST),
        ];
        return $this->createView(ViewConfig::OWNER_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_MANAGE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_MANAGE_OWNER, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_OWNER_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_OWNER_EDIT, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
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
        $changePwd = $httpTool->getBothSafeParam('change_pwd', HttpConfig::PARAM_NUMBER_TYPE);
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
        if (!empty($changePwd) && !empty($pwd)) {
            $userData = $this->changPassword($pwd, $userData);
        }
        if (isset($params['is_super'])) {
            $isSuper = $httpTool->getBothSafeParam('is_super', HttpConfig::PARAM_NUMBER_TYPE);
            $ownerData['is_super'] = !empty($isSuper)? $isSuper: 0;
        }
        return [$userData, $ownerData];
    }

    protected function validateRepeat(AdminUserProcessor $processor, $data)
    {
        $record = $processor->getSingleByName($data['name']);
        if (!empty($record)) {
            if ($record->id != $this->user->id) {
                $this->errorJson(500, '后台用户名已存在');
            }
        }
        $record = $processor->getSingleByPhone($data['phone']);
        if (!empty($record)) {
            if ($record->id != $this->user->id) {
                $this->errorJson(500, '后台用户电话已存在');
            }
        }
        return [true, 0, ''];
    }

    protected function update($userData, $ownerData)
    {
        if(empty($this->user)){
            $this->errorJson(500, '后台用户基本信息不存在');
        }
        if(empty($this->owner)){
            $this->errorJson(500, '后台用户信息不存在');
        }
        $this->getLogTool()->adminLog(2, $this->user->id, '编辑管理员');
        $adminUserProcessor = new AdminUserProcessor();
        list($res, $errorId, $message) = $this->validateRepeat($adminUserProcessor, $userData);
        if ($res == false) {
            $this->errorJson(500, $message);
        }
        $adminUserProcessor->update($this->user->id, $userData);
        (new AdminUserInfoProcessor())->update($this->owner->id, $ownerData);
        $this->successJson();
    }

    protected function process()
    {
        if (empty($this->owner)) {
            $this->errorJson(500, '记录不存在');
        }
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
        list($userData, $ownerData) = $this->initOwnerData();
        $this->update($userData, $ownerData);
    }
}