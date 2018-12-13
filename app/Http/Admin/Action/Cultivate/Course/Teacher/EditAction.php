<?php
/**
 * 编辑开班关联教师
 * Date: 2018/12/10
 * Time: 9:30
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
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class EditAction extends BaseAction
{
    use ApiActionTrait;

    protected $record = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = CultivateCourseTeacher::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $courseList = CultivateCourse::select(['no', 'name'])->get();
        $teacherList = CultivateTeacher::select(['no', 'name'])->get();
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'record'        => $this->record,
            'courseList'    => $courseList,
            'teacherList'   => $teacherList,
            'actionUrl'         => route(RouteConfig::ROUTE_COURSE_TEACHER_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_COURSE_TEACHER_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_TEACHER_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_COURSE_TEACHER, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_TEACHER_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_TEACHER_EDIT, 'url'=>0, 'active'=>1],
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
        if (!empty($sameRecord) && $sameRecord->id != $this->record->id) {
            $this->errorJson(500, '开班教师已存在');
        }
        $data = [
            'course_no'     =>  $courseNo,
            'teacher_no'    =>  $teacherNo,
        ];
        $res = $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function update($data)
    {
        $processor = new CourseTeacherProcessor();
        list($status, $courseId) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '编辑开班教师失败');
        }
        $this->getLogTool()->operateLog(61, $courseId, '编辑开班教师');
        $this->successJson();
    }
}