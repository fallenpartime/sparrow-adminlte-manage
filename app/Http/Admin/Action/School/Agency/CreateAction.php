<?php
/**
 * 创建机构
 * Date: 2018/12/9
 * Time: 19:27
 */
namespace App\Http\Admin\Action\School\Agency;

use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\School\Agency\Processor\AgencyProcessor;
use Common\Models\Cultivate\CultivateAgency;
use Frameworks\Traits\ApiActionTrait;

class CreateAction extends BaseInfoAction
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
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_AGENCY_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_AGENCY_LIST),
        ];
        return $this->createView(ViewConfig::AGENCY_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_AGENCY, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_AGENCY_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_AGENCY_CREATE, 'url'=>0, 'active'=>1],
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
        if (!empty($sameRecord)) {
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
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new AgencyProcessor();
        list($status, $agency) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '机构创建失败');
        }
        $this->getLogTool()->operateLog(1, $agency->id, '添加机构');
        $this->processCreateImage($data['logo'], $agency->id);
        $this->successJson();
    }
}