<?php
/**
 * 编辑专业
 * Date: 2018/12/10
 * Time: 8:59
 */
namespace App\Http\Admin\Action\Cultivate\Major;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Major\Processor\MajorProcessor;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateMajor;
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
            $this->record = CultivateMajor::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $result = [
            'record'            => $this->record,
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_MAJOR_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_MAJOR_LIST),
        ];
        return $this->createView(ViewConfig::MAJOR_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_MAJOR, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_EDIT, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $no = $httpTool->getBothSafeParam('no');
        $name = $httpTool->getBothSafeParam('name');
        $description = $httpTool->getBothSafeParam('description');
        $content = $httpTool->getBothSafeParam('content');
        $picPreview = $this->request->get('list_pic_preview');
        if(empty($no)){
            $this->errorJson(500, '专业编号不能为空');
        }
        $sameRecord = CultivateMajor::where('no', $no)->first();
        if (!empty($sameRecord) && $sameRecord->id != $this->record->id) {
            $this->errorJson(500, '专业编号已存在');
        }
        if(empty($name)){
            $this->errorJson(500, '专业名称不能为空');
        }
        $data = [
            'no'        =>  $no,
            'name'      =>  $name,
            'description'   =>  $description,
            'content'   =>  $content,
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
        $this->getLogTool()->operateLog(31, $this->record->id, '编辑培训专业');
        $processor = new MajorProcessor();
        list($status, $id) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '培训等级修改失败');
        }
        $this->successJson();
    }
}