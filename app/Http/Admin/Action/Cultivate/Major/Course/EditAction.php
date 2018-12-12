<?php
/**
 * 编辑专业课程
 * Date: 2018/12/11
 * Time: 23:25
 */
namespace App\Http\Admin\Action\Cultivate\Major\Course;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\MajorConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Major\Processor\MajorCourseProcessor;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorCourse;
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
            $this->record = CultivateMajorCourse::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        if (empty($this->record)) {
            $this->redirect('课程不存在');
        }
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        $levelList = CultivateMajorLevel::select(['no', 'name'])->get();
        $result = [
            'menu'          =>  $this->initViewMenu(),
            'record'        =>  $this->record,
            'majorList'     => $majorList,
            'levelList'     => $levelList,
            'typeList'      => MajorConfig::courseTypeMap(),
            'actionUrl'         => route(RouteConfig::ROUTE_MAJOR_COURSE_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_MAJOR_COURSE_LIST),
        ];
        return $this->createView(ViewConfig::MAJOR_COURSE_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_MAJOR_COURSE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_COURSE_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_COURSE_EDIT, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        if (empty($this->record)) {
            $this->errorJson(500, '课程不存在');
        }
        $httpTool = $this->getHttpTool();
        $no = $httpTool->getBothSafeParam('no');
        $name = $httpTool->getBothSafeParam('name');
        $type = $httpTool->getBothSafeParam('type');
        $levelNo = $httpTool->getBothSafeParam('level_no');
        $majorNo = $httpTool->getBothSafeParam('major_no');
        $description = $httpTool->getBothSafeParam('description');
        $picPreview = $this->request->get('list_pic_preview');
        if(empty($no)){
            $this->errorJson(500, '课程编号不能为空');
        }
        $sameRecord = CultivateMajorCourse::where('no', $no)->first();
        if (!empty($sameRecord) && $sameRecord->id != $this->record->id) {
            $this->errorJson(500, '课程编号已存在');
        }
        if(empty($name)){
            $this->errorJson(500, '课程名称不能为空');
        }
        if(empty($levelNo)){
            $this->errorJson(500, '课程等级不能为空');
        }
        if(empty($type)){
            $this->errorJson(500, '课程类型不能为空');
        }
        if(empty($majorNo)){
            $this->errorJson(500, '课程所属专业不能为空');
        }
        $data = [
            'no'        =>  $no,
            'name'      =>  $name,
            'type'      =>  $type,
            'level_no'  =>  $levelNo,
            'major_no'  =>  $majorNo,
            'description'   =>  $description,
            'image'      =>  !empty($picPreview)?  $picPreview[0]: null,
        ];
        $res = $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function update($data)
    {
        $this->getLogTool()->operateLog(41, $this->record->id, '编辑专业课程');
        $processor = new MajorCourseProcessor();
        list($status, $id) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '专业课程编辑失败');
        }
        $this->successJson();
    }
}