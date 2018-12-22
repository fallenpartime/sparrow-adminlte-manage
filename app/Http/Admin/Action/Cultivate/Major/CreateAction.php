<?php
/**
 * 创建专业
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
            'actionUrl'         => route(RouteConfig::ROUTE_MAJOR_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_MAJOR_LIST),
        ];
        return $this->createView(ViewConfig::MAJOR_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_MAJOR, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_MAJOR_CREATE, 'url'=>0, 'active'=>1],
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
        if (!empty($sameRecord)) {
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
            'show_status'   =>  1,
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
        $processor = new MajorProcessor();
        list($status, $agency) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '专业创建失败');
        }
        $this->getLogTool()->operateLog(30, $agency->id, '添加培训专业');
        $this->successJson();
    }

}