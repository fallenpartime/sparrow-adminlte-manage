<?php
/**
 * 权限列表
 * Date: 2018/12/1
 * Time: 22:37
 */
namespace App\Http\Admin\Action\System\Authority;

use Admin\Action\BaseAction;
use Admin\Config\ViewConfig;
use Admin\Services\Authority\AuthorityService;

class IndexAction extends BaseAction
{
    public function run()
    {
        $service = new AuthorityService();
        $list = $service->relateMenu([1,2,3], 1);
        $result = [
            'list'  =>  $list,
            'menu'  =>  [
                ['tag' => 'manage.center', 'url' => '', 'active' => 0],
                ['tag' => 'manage.authority', 'url' => '', 'active' => 0],
                ['tag' => 'system.authority', 'url' => '', 'active' => 1],
            ],
        ];
        return $this->createView(ViewConfig::AUTHORITY_LIST, $result);
    }
}