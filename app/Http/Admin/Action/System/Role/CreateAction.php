<?php
/**
 * 角色创建
 * Date: 2018/12/1
 * Time: 22:38
 */
namespace App\Http\Admin\Action\System\Role;

use Admin\Action\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleProcessor;
use Common\Models\System\AdminUserGroup;
use Common\Models\System\AdminUserRole;
use Common\Models\System\AdminUserRoleAccess;
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
        $service = new AuthorityService();
        $roleMenus = $service->relateMenu();
        $indexUrls = AdminConfig::indexUrlList();
        $result = [
            'roles'             =>  AdminUserRole::all(),
            'groups'            =>  $this->getAccess(),
            'authorities'       =>  $roleMenus,
            'indexUrls'         => $indexUrls,
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_ROLE), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_ROLE_LIST), 'url' => route(RouteConfig::ROUTE_ROLE_LIST), 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_ROLE_CREATE), 'url' => '', 'active' => 1],
            ],
            'actionUrl'         => route(RouteConfig::ROUTE_ROLE_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_ROLE_LIST),
        ];
        return $this->createView(ViewConfig::ROLE_CREATE, $result);
    }

    protected function getAccess()
    {
        $groupList = [];
        $groups = AdminUserGroup::all();
        if (!empty($groups)) {
            foreach ($groups as $group) {
                $groupNo = $group->group_no;
                $groupList[$groupNo] = ['model'=>$group, 'access'=>null];
            }
        }
        return $groupList;
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $roleNo = $httpTool->getBothSafeParam('no', HttpConfig::PARAM_NUMBER_TYPE);
        $name = $httpTool->getBothSafeParam('name');
        $name = trim($name);
        $indexUrl = $httpTool->getBothSafeParam('indexurl');
        $indexUrl = trim($indexUrl);
        if (empty($roleNo)) {
            $this->errorJson(500, '角色编号为空');
        }
        if (empty($name)) {
            $this->errorJson(500, '分组名为空');
        }
        $actions = $this->getActions();
        if ($roleNo > 1 && empty($actions)) {
            $this->errorJson(500, '权限不能为空');
        }
        if (empty($indexUrl)) {
            $this->errorJson(500, '入口地址为空');
        }
        if ($roleNo > 1) {
            if (!in_array($indexUrl, $actions)) {
                $this->errorJson(500, '入口地址不属于权限范畴');
            }
        }
        $data = [
            'role_no'   =>  $roleNo,
            'name'      =>  $name,
            'index_action'  =>  !empty($indexUrl)? $indexUrl: null,
            'actions'   =>  !empty($actions)? json_encode($actions): null,
        ];
        list($res, $id) = $this->store($data);
        $this->storeAccess($roleNo);
        $this->successJson();
    }

    protected function getActions()
    {
        $actions = $this->request->get('auth_checked');
        if (empty($actions)) {
            return null;
        }
        return array_unique($actions);
    }

    protected function storeAccess($roleNo)
    {
        if (!empty($roleNo)) {
            AdminUserRoleAccess::where('role_no', $roleNo)->delete();
            $groups = AdminUserGroup::all();
            if (empty($groups)) {
                return false;
            }
            $processor = new AdminUserRoleAccessProcessor();
            foreach ($groups as $group) {
                $groupNo = intval(request("{$group->tip}"));
                if ($groupNo > 0) {
                    $data = [
                        'group_no'  =>  $groupNo,
                        'role_no'   =>  $roleNo,
                        'leader_no' =>  0,
                        'is_leader' =>  0,
                    ];
                    $processor->insert($data);
                }
            }
        }
    }

    protected function validateRepeat(AdminUserRoleProcessor $processor, $data)
    {
        $record = $processor->getSingleByNo($data['role_no']);
        if (!empty($record)) {
            $this->errorJson(500, '角色No已存在');
        }
        $record = $processor->getSingleByName($data['name']);
        if (!empty($record)) {
            $this->errorJson(500, '角色名已存在');
        }
        return [true, 0];
    }

    protected function store($data)
    {
        $processor = new AdminUserRoleProcessor();
        list($res, $errorId) = $this->validateRepeat($processor, $data);
        if ($res == false) {
            return [$res, 0];
        }
        list($res, $model) = $processor->insert($data);
        $insertId = 0;
        if ($res) {
            $insertId = $model->id;
            $this->getLogTool()->adminLog(30, $model->id, '创建角色');
        }
        return [$res, $insertId];
    }
}