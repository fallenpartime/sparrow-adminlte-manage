<?php
/**
 * 创建开班
 * Date: 2018/12/10
 * Time: 8:56
 */
namespace App\Http\Admin\Action\Cultivate\Course;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Course\Processor\CourseProcessor;
use Admin\Services\Cultivate\Major\CourseService;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateCourse;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorLevel;
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
        $httpTool = $this->getHttpTool();
        $majorNo = $httpTool->getBothSafeParam('major_no');
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        $levelList = CultivateMajorLevel::select(['no', 'name'])->get();
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'major_no'      => $majorNo,
            'majorList'     => $majorList,
            'levelList'     => $levelList,
            'actionUrl'         => route(RouteConfig::ROUTE_COURSE_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_COURSE_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_COURSE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $name = $httpTool->getBothSafeParam('name');
        $year = $httpTool->getBothSafeParam('year', HttpConfig::PARAM_NUMBER_TYPE);
        $majorNo = $httpTool->getBothSafeParam('major_no');
        $levelNo = $httpTool->getBothSafeParam('level_no');
        $description = $httpTool->getBothSafeParam('description');
        $content = $httpTool->getBothSafeParam('content');
        $num = $httpTool->getBothSafeParam('num', HttpConfig::PARAM_NUMBER_TYPE);
        if(empty($year)){
            $this->errorJson(500, '开班年份不能为空');
        }
        if(empty($name)){
            $this->errorJson(500, '开班名称不能为空');
        }
        if(empty($majorNo)){
            $this->errorJson(500, '开班专业不能为空');
        }
        if(empty($levelNo)){
            $this->errorJson(500, '开班专业等级不能为空');
        }
        if(empty($num)){
            $this->errorJson(500, '开班期数不能为空');
        }
        $sameRecord = CultivateCourse::where('major_no', $majorNo)->where('level_no', $levelNo)->first();
        if (!empty($sameRecord)) {
            $this->errorJson(500, '开班已存在');
        }
        $data = [
            'name'      =>  $name,
            'year'      =>  $year,
            'major_no'  =>  $majorNo,
            'level_no'  =>  $levelNo,
            'description'   =>  $description,
            'content'   =>  $content,
            'num'       =>  $num,
        ];
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new CourseProcessor();
        list($status, $course) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '开班创建失败');
        }
        $course->no = CourseService::createCourseNo($course->year, $course->major_no, $course->level_no, $course->num);
        $course->save();
        $this->getLogTool()->operateLog(50, $course->id, '添加开班');
        $this->successJson();
    }
}