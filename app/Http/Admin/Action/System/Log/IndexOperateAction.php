<?php
/**
 * 业务日志
 * Date: 2018/12/3
 * Time: 15:10
 */
namespace App\Http\Admin\Action\System\Log;


use Admin\Action\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Owner\OwnerService;
use Admin\Services\Sql\System\Log\OperateLogSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\System\OperateLog;

class IndexOperateAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_OPERATE_LOG_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new OperateLogSqlProcessor())->getListSql(new OperateLog(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('user')->select(['id', 'user_id', 'operate_type', 'object_id', 'memo', 'ip', 'created_at'])->get();
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        $typeList = AdminConfig::getOperateList();
        $owners = (new OwnerService())->ownerList();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'typeList'      => $typeList,
            'owners'        => $owners,
            'menu'  =>  $this->initViewMenu(),
        ];
        return $this->createView(ViewConfig::LOG_OPERATE_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_MANAGE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_MANAGE_LOG, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_OPERATE_LOG_LIST, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }
}