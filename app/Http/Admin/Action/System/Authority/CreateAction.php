<?php
/**
 * 权限创建
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
        $authorityService = new AuthorityService();
        $result = [
            'relate_menu'   => $authorityService->relateMenu([1,2]),
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_AUTHORITY_LIST), 'url' => route(RouteConfig::ROUTE_AUTHORITY_LIST), 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_AUTHORITY_CREATE), 'url' => '', 'active' => 1],
            ],
            'actionUrl'     => route(RouteConfig::ROUTE_AUTHORITY_CREATE),
            'redirectUrl'   => route(RouteConfig::ROUTE_AUTHORITY_LIST),
        ];
        return $this->createView(ViewConfig::AUTHORITY_CREATE, $result);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $first_id = $httpTool->getBothSafeParam('first_menu', HttpConfig::PARAM_NUMBER_TYPE);
        $second_id = $httpTool->getBothSafeParam('second_menu', HttpConfig::PARAM_NUMBER_TYPE);
        $second_id = !empty($first_id)? $second_id: 0;
        $tsName = $httpTool->getBothSafeParam('ts_name');
        $tsAction = trim($_REQUEST['ts_action']);
        $type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
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
        list($res, $id) = $this->store($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function store($data)
    {
        $processor = new AdminActionProcessor();
        $actionRecord = $processor->getSingleByAction($data['ts_action']);
        if (!empty($actionRecord)) {
            $this->errorJson(500, '权限标示已存在');
        }
        $nameRecord = $processor->getSingleByName($data['name']);
        if (!empty($nameRecord)) {
            $this->errorJson(500, '权限名已存在');
        }
        list($res, $model) = $processor->insert($data);
        $this->getLogTool()->_init($this->getAuthService()->getAdminInfo())->adminLog(10, $model->id, '创建权限');
        $insertId = $res? $model->id: 0;
        return [$res, $insertId];
    }
}