<?php
/**
 * 角色列表
 * Date: 2018/12/1
 * Time: 22:37
 */
namespace App\Http\Admin\Action\System\Role;

use Admin\Action\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Common\Models\System\AdminUserRole;

class IndexAction extends BaseAction
{
    public function run()
    {
        $list = AdminUserRole::with('accesses')->get();
        $result = [
            'list'  =>  $this->processList($list),
            'menu'  =>  [
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_CENTER), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(AdminMenuConfig::MENU_MANAGE_ROLE), 'url' => '', 'active' => 0],
                ['title' => AdminMenuConfig::getMenuName(RouteConfig::ROUTE_ROLE_LIST), 'url' => '', 'active' => 1],
            ],
        ];
        return $this->createView(ViewConfig::ROLE_LIST, $result);
    }

    protected function processList($list)
    {
        $outList = [];
        $groupList = [];
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                $unit = [
                    'no'        =>  $item->role_no,
                    'name'      =>  $item->name,
                    'actions'   =>  $item->actions,
                    'indexTag'  =>  AdminConfig::getIndexUrl($item->index_action, 'title'),
                    'group_desc'    =>  [],
                    'group_ext'     =>  [],
                    'created_at'    =>  $item->created_at,
                    'edit_url'      =>  route(RouteConfig::ROUTE_ROLE_EDIT, ['id'=>$item->id]),
                ];
                $accesses = array_get($item, 'accesses');
                if (!empty($accesses)) {
                    foreach ($accesses as $access) {
                        $groupNo = $access->group_no;
                        if (array_key_exists($groupNo, $groupList)) {
                            $group = $groupList[$groupNo];
                        } else {
                            $group = array_get($access, 'group');
                            if (empty($group)) {
                                continue;
                            }
                        }
                        $groupName  = $group->name;
                        $unit['group_desc'][] = "分组:{$groupName}";
                    }
                }
                $unit['group_desc'] = implode('<br>', $unit['group_desc']);
                $outList[] = $unit;
            }
        }
        return $outList;
    }
}