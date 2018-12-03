<?php
/**
 * 权限编辑
 * Date: 2018/12/1
 * Time: 22:38
 */
namespace App\Http\Admin\Action\System\Authority;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Services\Authority\AuthorityService;
use Common\Models\System\AdminAction;
use Frameworks\Tool\Http\Config\HttpConfig;

class EditAction extends BaseAction
{
    protected $record = [];

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = AdminAction::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        list($firstId, $secondId) = $this->getParentId($this->record);
        $authorityService = new AuthorityService();
        $result = [
            'record'        => $this->record,
            'relate_menu'   => $authorityService->relateMenu([1,2]),
            'first_menu'    => $firstId,
            'second_menu'   => $secondId,
            'menu'  =>  [
                AdminMenuConfig::MENU_MANAGE_CENTER => ['tag' => AdminMenuConfig::MENU_MANAGE_CENTER, 'title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                AdminMenuConfig::MENU_MANAGE_AUTHORITY => ['tag' => AdminMenuConfig::MENU_MANAGE_AUTHORITY, 'title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
            ],
            'actionUrl'     => route(RouteConfig::ROUTE_AUTHORITY_EDIT),
            'redirectUrl'   => route(RouteConfig::ROUTE_AUTHORITY_LIST),
        ];
        return $this->createView('admin.system.authority.detail', $result);
    }

    private function getParentId($authorization)
    {
        $firstId = $secondId = 0;
        if (!empty($authorization)) {
            $parentId = $authorization->parent_id;
            $type = $authorization->type;
            if($type == 2){
                $firstId = $parentId;
            }else if($type == 3){
                $parentAuth = AdminAction::find($parentId);
                if (!empty($parentAuth) && $parentAuth->type == 2) {
                    $secondId = $parentId;
                    $parentAuth = AdminAction::find($parentAuth->parent_id);
                    if (!empty($parentAuth) && $parentAuth->type == 1) {
                        $firstId = $parentAuth->id;
                    }
                }
            }
        }
        return [$firstId, $secondId];
    }

    protected function process()
    {

    }
}