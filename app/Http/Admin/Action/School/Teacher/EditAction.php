<?php
/**
 * 编辑机构教师
 * Date: 2018/12/10
 * Time: 8:46
 */
namespace App\Http\Admin\Action\School\Teacher;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\School\Teacher\Processor\TeacherProcessor;
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
            $this->record = CultivateTeacher::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $result = [
            'record'    =>  $this->record,
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_TEACHER_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_TEACHER_LIST),
        ];
        return $this->createView(ViewConfig::TEACHER_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_TEACHER, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_TEACHER_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_TEACHER_EDIT, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $no = $httpTool->getBothSafeParam('no');
        $name = $httpTool->getBothSafeParam('name');
        $phone = $httpTool->getBothSafeParam('phone');
        $address = $httpTool->getBothSafeParam('address');
        $description = $httpTool->getBothSafeParam('description');
        $sex = $httpTool->getBothSafeParam('sex', HttpConfig::PARAM_NUMBER_TYPE);
        $birthday = $httpTool->getBothSafeParam('birthday');
        $positional = $httpTool->getBothSafeParam('positional', HttpConfig::PARAM_NUMBER_TYPE);
        $diploma = $httpTool->getBothSafeParam('diploma', HttpConfig::PARAM_NUMBER_TYPE);
        $degree = $httpTool->getBothSafeParam('degree', HttpConfig::PARAM_NUMBER_TYPE);
        $duty = $httpTool->getBothSafeParam('duty', HttpConfig::PARAM_NUMBER_TYPE);
        if(empty($no)){
            $this->errorJson(500, '教师编号不能为空');
        }
        $sameRecord = CultivateTeacher::where('no', $no)->first();
        if (!empty($sameRecord) && $sameRecord->id != $this->record->id) {
            $this->errorJson(500, '教师编号已存在');
        }
        if(empty($name)){
            $this->errorJson(500, '教师名称不能为空');
        }
        if(empty($phone)){
            $this->errorJson(500, '电话不能为空');
        }
        $data = [
            'no'        =>  $no,
            'name'      =>  $name,
            'phone'     =>  $phone,
            'address'   =>  $address,
            'description'   =>  $description,
            'sex'       =>  !empty($sex)? $sex: 0,
            'birthday'  =>  !empty($birthday)? $birthday: null,
            'positional'    =>  !empty($positional)? $positional: 0,
            'diploma'    =>  !empty($diploma)? $diploma: 0,
            'degree'    =>  !empty($degree)? $degree: 0,
            'duty'      =>  !empty($duty)? $duty: 0,
        ];
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $this->getLogTool()->operateLog(11, $this->record->id, '编辑教师');
        $processor = new TeacherProcessor();
        list($status, $id) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '教师修改失败');
        }
        $this->successJson();
    }
}