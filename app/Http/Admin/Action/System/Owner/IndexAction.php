<?php
/**
 * 管理员列表
 * Date: 2018/12/1
 * Time: 22:37
 */
namespace App\Http\Admin\Action\System\Owner;

use Admin\Action\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Sql\System\Owner\IndexSqlProcessor;
use Common\Models\System\AdminUserInfo;
use Frameworks\Traits\ApiActionTrait;

class IndexAction extends BaseAction
{
    use ApiActionTrait;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $model = AdminUserInfo::with(['user', 'role']);
        list($model, $urlParams) = (new IndexSqlProcessor())->getListSql(new AdminUserInfo(), $httpTool->getParams(), '');
        $list = $model->get();
        $result = [
            'list'  =>  $this->processList($list),
            'urlParams'     =>  $urlParams,
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_AUTHORITY), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_OWNER_LIST), 'url' => '', 'active' => 1],
            ]
        ];
        return $this->createView(ViewConfig::OWNER_LIST, $result);
    }

    protected function processList($list)
    {
        $outList = [];
        if (!empty($list)) {
            foreach ($list as $item) {
                $unitOwner = [
                    'id'    =>  $item->id,
                    'user_id'       =>  $item->user_id,
                    'role_no'       =>  '',
                    'role_name'     =>  '',
                    'is_owner'      =>  $item->is_owner,
                    'name'  =>  '',
                    'phone' =>  '',
                    'status_desc'   =>  $this->getStatusDescription($item),
                    'edit_url'      =>  route(RouteConfig::ROUTE_OWNER_EDIT, ['id'=>$item->id]),
                    'indexTag'      =>  '',
                    'created_at'    =>  $item->created_at,
                ];
                if (!empty($item->role)) {
                    $unitOwner['role_no']  = $item->role->role_no;
                    $unitOwner['role_name'] = $item->role->name;
                    $unitOwner['indexTag'] = AdminConfig::getIndexUrl($item->role->index_action, 'title');
                }
                if (!empty($item->user)) {
                    $unitOwner['name']  = $item->user->name;
                    $unitOwner['phone'] = $item->user->phone;
                }
                $outList[] = $unitOwner;
            }
        }
        return $outList;
    }

    protected function getStatusDescription($item)
    {
        $description = [];
        $description[] = '是否激活：'.(!empty($item->is_admin)? '是': '否');
        $description[] = '是否超级管理员：'.(!empty($item->is_super)? '是': '否');
        return implode('<br>', $description);
    }
}