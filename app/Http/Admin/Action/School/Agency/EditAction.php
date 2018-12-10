<?php
/**
 * 编辑机构
 * Date: 2018/12/9
 * Time: 19:28
 */

namespace App\Http\Admin\Action\School\Agency;

use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\School\Agency\Processor\AgencyProcessor;
use Common\Models\Cultivate\CultivateAgency;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class EditAction extends BaseInfoAction
{
    use ApiActionTrait;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = CultivateAgency::find($id);
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
            'actionUrl'         => route(RouteConfig::ROUTE_AGENCY_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_AGENCY_LIST),
        ];
        return $this->createView(ViewConfig::AGENCY_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_AGENCY, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_AGENCY_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_AGENCY_EDIT, 'url'=>0, 'active'=>1],
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
        $picPreview = $this->request->get('list_pic_preview');
        if(empty($no)){
            $this->errorJson(500, '机构编号不能为空');
        }
        $sameRecord = CultivateAgency::where('no', $no)->first();
        if (!empty($sameRecord) && $sameRecord->id != $this->record->id) {
            $this->errorJson(500, '机构编号已存在');
        }
        if(empty($name)){
            $this->errorJson(500, '机构名称不能为空');
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
            'logo'      =>  !empty($picPreview)?  $picPreview[0]: null,
        ];
        $res = $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function update($data)
    {
        $this->getLogTool()->operateLog(2, $this->record->id, '编辑机构');
        $processor = new AgencyProcessor();
        list($status, $id) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '机构修改失败');
        }
        $this->processEditImage($data['logo'], $id);
        $this->successJson();
    }
}