<?php
/**
 * 专业列表
 * Date: 2018/12/11
 * Time: 23:26
 */
namespace App\Http\Admin\Action\Cultivate\Major\Course;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\MajorConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Cultivate\Major\Course\MajorCourseSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorCourse;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_MAJOR_COURSE_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new MajorCourseSqlProcessor())->getListSql(new CultivateMajorCourse(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('major')->select(['id', 'no', 'major_no', 'name', 'image', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'majorList'     => $majorList,
            'typeList'      => MajorConfig::courseTypeMap(),
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_MAJOR_COURSE_LIST),
        ];
        return $this->createView(ViewConfig::MAJOR_COURSE_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_CULTIVATE_MAJOR_COURSE, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_MAJOR_COURSE_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route(RouteConfig::ROUTE_MAJOR_COURSE_EDIT, ['id'=>$item->id]);
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
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_COURSE_REMOVE)) {
            $operateList['allow_remove'] = 1;
            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_MAJOR_COURSE_REMOVE);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_remove' => 0,
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_COURSE_EDIT)) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_MAJOR_COURSE_REMOVE)) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}