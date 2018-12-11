<?php
/**
 * 创建专业等级
 * Date: 2018/12/10
 * Time: 8:56
 */
namespace App\Http\Admin\Action\Cultivate\Level;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Level\Processor\MajorLevelProcessor;
use Admin\Services\Menu\AdminMenuService;
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
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_LEVEL_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_LEVEL_LIST),
        ];
        return $this->createView(ViewConfig::LEVEL_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_LEVEL, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_LEVEL_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_LEVEL_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $no = $httpTool->getBothSafeParam('no');
        $name = $httpTool->getBothSafeParam('name');
        $picPreview = $this->request->get('list_pic_preview');
        if(empty($no)){
            $this->errorJson(500, '等级编号不能为空');
        }
        $sameRecord = CultivateMajorLevel::where('no', $no)->first();
        if (!empty($sameRecord)) {
            $this->errorJson(500, '等级编号已存在');
        }
        if(empty($name)){
            $this->errorJson(500, '等级名称不能为空');
        }
        $data = [
            'no'        =>  $no,
            'name'      =>  $name,
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
        $processor = new MajorLevelProcessor();
        list($status, $agency) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '等级创建失败');
        }
        $this->getLogTool()->operateLog(20, $agency->id, '添加培训等级');
        $this->successJson();
    }
}