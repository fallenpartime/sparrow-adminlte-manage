<?php
/**
 * 授课老师列表
 * Date: 2018/12/5
 * Time: 12:37
 */
namespace App\Http\Admin\Action\School\Teacher;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\School\Teacher\TeacherSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateTeacher;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_TEACHER_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new TeacherSqlProcessor())->getListSql(new CultivateTeacher(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->select(['id', 'no', 'name', 'phone', 'face', 'description', 'sex', 'duty', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_TEACHER_LIST),
        ];
        return $this->createView(ViewConfig::TEACHER_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_CULTIVATE_TEACHER, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_TEACHER_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route(RouteConfig::ROUTE_TEACHER_EDIT, ['id'=>$item->id]);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_remove' => 0,
        ];
        $operateUrl = [
            'remove_url' => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_TEACHER_REMOVE)) {
            $operateList['allow_remove'] = 1;
            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_TEACHER_REMOVE);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_remove' => 0
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_TEACHER_EDIT)) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_TEACHER_REMOVE)) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}