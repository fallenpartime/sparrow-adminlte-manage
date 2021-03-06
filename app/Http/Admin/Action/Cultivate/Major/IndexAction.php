<?php
/**
 * 专业列表
 * Date: 2018/12/5
 * Time: 12:37
 */
namespace App\Http\Admin\Action\Cultivate\Major;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Cultivate\Major\MajorSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateMajor;

class IndexAction extends BaseAction
{

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_MAJOR_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new MajorSqlProcessor())->getListSql(new CultivateMajor(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->select(['id', 'no', 'name', 'image', 'created_at'])->get();
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
            'redirectUrl'   => route(RouteConfig::ROUTE_MAJOR_LIST),
        ];
        return $this->createView(ViewConfig::MAJOR_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_CULTIVATE_MAJOR, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_MAJOR_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route(RouteConfig::ROUTE_MAJOR_EDIT, ['id'=>$item->id]);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_remove' => 0,
            'allow_create_course' => 0,
            'allow_create_kcourse' => 0,
        ];
        $operateUrl = [
            'remove_url' => '',
            'create_course_url' => '',
            'create_kcourse_url' => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_REMOVE)) {
            $operateList['allow_remove'] = 1;
            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_MAJOR_REMOVE);
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_COURSE_CREATE)) {
            $operateList['allow_create_course'] = 1;
            $operateUrl['create_course_url'] = route(RouteConfig::ROUTE_MAJOR_COURSE_CREATE);
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_CREATE)) {
            $operateList['allow_create_kcourse'] = 1;
            $operateUrl['create_kcourse_url'] = route(RouteConfig::ROUTE_COURSE_CREATE);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_create_course' => 0,
            'allow_operate_create_kcourse' => 0,
            'allow_operate_remove' => 0,
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_EDIT)) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_COURSE_CREATE)) {
            $operateList['allow_operate_create_course'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_CREATE)) {
            $operateList['allow_operate_create_kcourse'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_REMOVE)) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }

}