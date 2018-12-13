<?php
/**
 * 编辑开班
 * Date: 2018/12/13
 * Time: 20:49
 */
namespace App\Http\Admin\Action\Cultivate\Course;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Course\Processor\CoursePriceProcessor;
use Admin\Services\Cultivate\Major\CourseService;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateCourse;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorLevel;
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
            $this->record = CultivateCourse::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        if (empty($this->record)) {
            $this->redirect('开班不存在');
        }
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        $levelList = CultivateMajorLevel::select(['no', 'name'])->get();
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'record'        => $this->record,
            'majorList'     => $majorList,
            'levelList'     => $levelList,
            'actionUrl'         => route(RouteConfig::ROUTE_COURSE_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_COURSE_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_COURSE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_EDIT, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $no = $httpTool->getBothSafeParam('no');
        $name = $httpTool->getBothSafeParam('name');
        $year = $httpTool->getBothSafeParam('year', HttpConfig::PARAM_NUMBER_TYPE);
        $majorNo = $httpTool->getBothSafeParam('major_no');
        $levelNo = $httpTool->getBothSafeParam('level_no');
        $description = $httpTool->getBothSafeParam('description');
        $num = $httpTool->getBothSafeParam('num', HttpConfig::PARAM_NUMBER_TYPE);
        if(empty($no)){
            $this->errorJson(500, '开班编号不能为空');
        }
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
        if (!empty($sameRecord) && $this->record->id != $sameRecord->id) {
            $this->errorJson(500, '开班已存在');
        }
        $noRecord = CultivateCourse::where('no', $no)->first();
        if (!empty($noRecord) && $this->record->id != $noRecord->id) {
            $this->errorJson(500, '开班编号已存在');
        }
        $data = [
            'no'        =>  $no,
            'name'      =>  $name,
            'year'      =>  $year,
            'major_no'  =>  $majorNo,
            'level_no'  =>  $levelNo,
            'description'   =>  $description,
            'num'       =>  $num,
        ];
        $res = $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function update($data)
    {
        $processor = new CoursePriceProcessor();
//        $data['no'] = CourseService::createCourseNo(array_get($data, 'year'), array_get($data, 'major_no'), array_get($data, 'level_no'), array_get($data, 'num'));
        list($status, $courseId) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '开班编辑失败');
        }
        $this->getLogTool()->operateLog(51, $courseId, '编辑开班');
        $this->successJson();
    }
}