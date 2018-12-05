<?php
/**
 * 分组创建
 * Date: 2018/12/1
 * Time: 22:38
 */
namespace App\Http\Admin\Action\System\Group;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\Processor\AdminUserGroupProcessor;
use Admin\Services\Menu\AdminMenuService;
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
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'     => route(RouteConfig::ROUTE_GROUP_CREATE),
            'redirectUrl'   => route(RouteConfig::ROUTE_GROUP_LIST),
        ];
        return $this->createView(ViewConfig::GROUP_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_MANAGE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_MANAGE_GROUP, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_GROUP_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_GROUP_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $groupNo = $httpTool->getBothSafeParam('group_no', HttpConfig::PARAM_NUMBER_TYPE);
        $name = $httpTool->getBothSafeParam('name');
        $name = trim($name);
        $tip = $httpTool->getBothSafeParam('tip');
        $tip = trim($tip);
        if(empty($groupNo)){
            $this->errorJson(500, '分组编号为空');
        }
        if(empty($name)){
            $this->errorJson(500, '分组名为空');
        }
        if(empty($tip)){
            $this->errorJson(500, '分组Tip为空');
        }
        $data = [
            'group_no'  =>  $groupNo,
            'name'      =>  $name,
            'tip'       =>  $tip,
        ];
        list($res, $id) = $this->store($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function validateRepeat(AdminUserGroupProcessor $processor, $data)
    {
        $record = $processor->getSingleByNo($data['group_no']);
        if (!empty($record)) {
            $this->errorJson(500, '分组编号已存在');
        }
        $record = $processor->getSingleByName($data['name']);
        if (!empty($record)) {
            $this->errorJson(500, '分组名已存在');
        }
        $record = $processor->getSingleByTip($data['tip']);
        if (!empty($record)) {
            $this->errorJson(500, '分组Tip已存在');
        }
        return [true, 0];
    }

    protected function store($data)
    {
        $processor = new AdminUserGroupProcessor();
        list($res, $errorId) = $this->validateRepeat($processor, $data);
        if ($res == false) {
            return [$res, 0];
        }
        list($res, $model) = $processor->insert($data);
        $insertId = 0;
        if ($res) {
            $insertId = $model->id;
            $this->getLogTool()->adminLog(20, $model->id, '创建分组');
        }
        return [$res, $insertId];
    }
}