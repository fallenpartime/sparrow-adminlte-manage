<?php
/**
 * 创建专业课程
 * Date: 2018/12/11
 * Time: 23:25
 */
namespace App\Http\Admin\Action\Cultivate\Major\Course;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Common\Config\MajorConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Major\Processor\MajorCourseProcessor;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorCourse;
use Common\Models\Cultivate\CultivateMajorLevel;
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
            'typeList'      => MajorConfig::courseTypeMap(),
            'actionUrl'         => route(RouteConfig::ROUTE_MAJOR_COURSE_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_MAJOR_COURSE_LIST),
        ];
        return $this->createView(ViewConfig::MAJOR_COURSE_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_MAJOR_COURSE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_COURSE_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_COURSE_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
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
        if (!empty($sameRecord)) {
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
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new MajorCourseProcessor();
        list($status, $model) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '专业课程创建失败');
        }
        $this->getLogTool()->operateLog(40, $model->id, '添加专业课程');
        $this->successJson();
    }

}