<?php
/**
 * 管理员菜单
 * Date: 2018/12/4
 * Time: 17:21
 */
namespace Admin\Services\Authority\Integration;

use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class OwnerMenuIntegration extends BaseWorkProcessor
{
    protected $owner = null;
    protected $menus = [];

    public function __construct($owner)
    {
        $this->owner = $owner;
    }

    protected function signOwnerMenu($menus)
    {
        if (!empty($this->owner)) {
            list($stauts, $message, $ts_list) = (new OwnerAuthoritiesIntegration($this->owner))->process();
            list($status, $count, $menus) = (new RelateAuthoritiesCheckedIntegration($menus, $ts_list))->process();
        }
        return $menus;
    }

    public function process()
    {
        $integration = new RelateAuthoritiesIntegration([1,2,3], 0, ['id', 'parent_id', 'type', 'name', 'ts_action']);
        list($status, $message, $count, $menus) = $integration->process();
        if (empty($status)) {
            return [];
        }
        $menus = $this->signOwnerMenu($menus);
        return $menus;
    }
}