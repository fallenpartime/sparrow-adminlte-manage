<?php
/**
 * 开班关联老师列表
 * Date: 2018/12/10
 * Time: 8:48
 */
namespace App\Http\Admin\Action\Cultivate\Course\Teacher;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Cultivate\Course\Teacher\CourseTeacherSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateCourse;
use Common\Models\Cultivate\CultivateCourseTeacher;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorLevel;
use Common\Models\Cultivate\CultivateTeacher;

class IndexAction extends BaseAction
{

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_COURSE_TEACHER_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new CourseTeacherSqlProcessor())->getListSql(new CultivateCourseTeacher(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with(['course', 'teacher'])->select(['id', 'course_no', 'teacher_no', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        $courseList = CultivateCourse::select(['no', 'name'])->get();
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        $levelList = CultivateMajorLevel::select(['no', 'name'])->get();
        $teacherList = CultivateTeacher::select(['no', 'name'])->get();
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'courseList'    => $courseList,
            'majorList'     => $majorList,
            'levelList'     => $levelList,
            'teacherList'   => $teacherList,
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_COURSE_TEACHER_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_TEACHER_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_CULTIVATE_COURSE_TEACHER, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_COURSE_TEACHER_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route(RouteConfig::ROUTE_COURSE_TEACHER_EDIT, ['id'=>$item->id]);
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
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_TEACHER_REMOVE)) {
            $operateList['allow_remove'] = 1;
            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_COURSE_TEACHER_REMOVE);
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
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_TEACHER_EDIT)) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_TEACHER_REMOVE)) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}