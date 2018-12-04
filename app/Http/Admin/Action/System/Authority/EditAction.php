<?php
/**
 * 权限编辑
 * Date: 2018/12/1
 * Time: 22:38
 */
namespace App\Http\Admin\Action\System\Authority;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Processor\AdminActionProcessor;
use Common\Models\System\AdminAction;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class EditAction extends BaseAction
{
    use ApiActionTrait;

    protected $record = [];

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = AdminAction::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        if (empty($this->record)) {
            $this->redirect('权限不存在', route(RouteConfig::ROUTE_AUTHORITY_LIST));
        }
        list($firstId, $secondId) = $this->getParentId($this->record);
        $authorityService = new AuthorityService();
        $result = [
            'record'        => $this->record,
            'relate_menu'   => $authorityService->relateMenu([1,2]),
            'first_menu'    => $firstId,
            'second_menu'   => $secondId,
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_AUTHORITY_LIST), 'url' => route(RouteConfig::ROUTE_AUTHORITY_LIST), 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_AUTHORITY_EDIT), 'url' => '', 'active' => 1],
            ],
            'actionUrl'     => route(RouteConfig::ROUTE_AUTHORITY_EDIT),
            'redirectUrl'   => route(RouteConfig::ROUTE_AUTHORITY_LIST),
        ];
        return $this->createView(ViewConfig::AUTHORITY_EDIT, $result);
    }

    private function getParentId($authorization)
    {
        $firstId = $secondId = 0;
        if (!empty($authorization)) {
            $parentId = $authorization->parent_id;
            $type = $authorization->type;
            if ($type == 2) {
                $firstId = $parentId;
            } else if($type == 3) {
                $parentAuth = AdminAction::find($parentId);
                if (!empty($parentAuth) && $parentAuth->type == 2) {
                    $secondId = $parentId;
                    $parentAuth = AdminAction::find($parentAuth->parent_id);
                    if (!empty($parentAuth) && $parentAuth->type == 1) {
                        $firstId = $parentAuth->id;
                    }
                }
            }
        }
        return [$firstId, $secondId];
    }

    protected function process()
    {
        if (empty($this->record)) {
            $this->errorJson(500, '记录不存在');
        }
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $first_id = $httpTool->getBothSafeParam('first_menu', HttpConfig::PARAM_NUMBER_TYPE);
        $second_id = $httpTool->getBothSafeParam('second_menu', HttpConfig::PARAM_NUMBER_TYPE);
        $second_id = !empty($first_id)? $second_id: 0;
        $tsName = $httpTool->getBothSafeParam('ts_name');
        $tsAction = trim($_REQUEST['ts_action']);
        $type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        $record = $this->record;
        if (!empty($id)) {
            if (empty($record)) {
                $this->errorJson(500, '修改权限不存在');
            }
        }
        if (empty($tsName) || empty($tsAction) || empty($type)) {
            $this->errorJson(500, '缺少权限主要信息');
        }
        if ($first_id) {
            if ($second_id) {
                if ($type != 3) {
                    $this->errorJson(500, '请选择操作权限');
                }
            } else {
                if ($type != 2) {
                    $this->errorJson(500, '请选择二级权限');
                }
            }
        } elseif ($type != 1) {
            $this->errorJson(500, '请选择一级权限');
        }
        if($second_id){
            $parent_id = $second_id;
        }else{
            $parent_id = $first_id? $first_id: 0;
        }
        $data = [
            'parent_id' =>  $parent_id,
            'type'      =>  $type,
            'ts_action' =>  $tsAction,
            'name'      =>  $tsName,
        ];
        list($res, $id) = $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function update($data)
    {
        $processor = new AdminActionProcessor();
        $actionRecord = $processor->getSingleByAction($data['ts_action']);
        if (!empty($actionRecord) && $actionRecord->id != $this->record->id) {
            $this->errorJson(500, '权限标示已存在');
        }
        $nameRecord = $processor->getSingleByName($data['name']);
        if (!empty($nameRecord) && $actionRecord->id != $this->record->id) {
            $this->errorJson(500, '权限名已存在');
        }
        $this->getLogTool()->_init($this->getAuthService()->getAdminInfo())->adminLog(11, $this->record->id, '编辑权限');
        return $processor->update($this->record->id, $data);
    }
}