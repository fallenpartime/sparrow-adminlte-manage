<?php
/**
 * 开班列表
 * Date: 2018/12/5
 * Time: 12:37
 */
namespace App\Http\Admin\Action\Cultivate\Course;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Cultivate\Course\CourseSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateCourse;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorLevel;

class IndexAction extends BaseAction
{

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_COURSE_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new CourseSqlProcessor())->getListSql(new CultivateCourse(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with(['major', 'level', 'price'])->select(['id', 'no', 'name', 'year', 'level_no', 'major_no', 'price_no', 'num', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        $levelList = CultivateMajorLevel::select(['no', 'name'])->get();
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'majorList'     => $majorList,
            'levelList'     => $levelList,
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_COURSE_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_CULTIVATE_COURSE, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_COURSE_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route(RouteConfig::ROUTE_COURSE_EDIT, ['id'=>$item->id]);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_remove' => 0,
            'allow_create_teacher' => 0,
            'allow_create_price' => 0,
        ];
        $operateUrl = [
            'remove_url' => '',
            'create_teacher_url' => '',
            'create_price_url' => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_REMOVE)) {
            $operateList['allow_remove'] = 1;
            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_COURSE_REMOVE);
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_TEACHER_CREATE)) {
            $operateList['allow_create_teacher'] = 1;
            $operateUrl['create_teacher_url'] = route(RouteConfig::ROUTE_COURSE_TEACHER_CREATE);
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_PRICE_CREATE)) {
            $operateList['allow_create_price'] = 1;
            $operateUrl['create_price_url'] = route(RouteConfig::ROUTE_COURSE_PRICE_CREATE);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_create_teacher' => 0,
            'allow_operate_create_price' => 0,
            'allow_operate_remove' => 0,
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_EDIT)) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_TEACHER_CREATE)) {
            $operateList['allow_operate_create_teacher'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_PRICE_CREATE)) {
            $operateList['allow_operate_create_price'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_REMOVE)) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}