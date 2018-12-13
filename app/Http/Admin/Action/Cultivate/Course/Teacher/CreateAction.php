<?php
/**
 * 创建开班关联教师
 * Date: 2018/12/11
 * Time: 23:31
 */
namespace App\Http\Admin\Action\Cultivate\Course\Teacher;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Course\Processor\CourseTeacherProcessor;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateCourse;
use Common\Models\Cultivate\CultivateCourseTeacher;
use Common\Models\Cultivate\CultivateTeacher;
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
        $httpTool = $this->getHttpTool();
        $courseNo = $httpTool->getBothSafeParam('course_no');
        $courseList = CultivateCourse::select(['no', 'name'])->get();
        $teacherList = CultivateTeacher::select(['no', 'name'])->get();
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'course_no'     => $courseNo,
            'courseList'    => $courseList,
            'teacherList'   => $teacherList,
            'actionUrl'         => route(RouteConfig::ROUTE_COURSE_TEACHER_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_COURSE_TEACHER_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_TEACHER_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_COURSE_TEACHER, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_TEACHER_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_TEACHER_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $courseNo = $httpTool->getBothSafeParam('course_no');
        $teacherNo = $httpTool->getBothSafeParam('teacher_no');
        if(empty($courseNo)){
            $this->errorJson(500, '开班不能为空');
        }
        $course = CultivateCourse::where('no', $courseNo)->first();
        if (empty($course)) {
            $this->errorJson(500, '开班记录不存在');
        }
        if(empty($teacherNo)){
            $this->errorJson(500, '开班教师不能为空');
        }
        $teacher = CultivateTeacher::where('no', $teacherNo)->first();
        if (empty($teacher)) {
            $this->errorJson(500, '教师记录不存在');
        }
        $sameRecord = CultivateCourseTeacher::where('course_no', $courseNo)->where('teacher_no', $teacherNo)->first();
        if (!empty($sameRecord)) {
            $this->errorJson(500, '开班教师已存在');
        }
        $data = [
            'course_no'     =>  $courseNo,
            'teacher_no'    =>  $teacherNo,
        ];
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new CourseTeacherProcessor();
        list($status, $course) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '开班教师创建失败');
        }
        $this->getLogTool()->operateLog(60, $course->id, '添加开班教师');
        $this->successJson();
    }
}