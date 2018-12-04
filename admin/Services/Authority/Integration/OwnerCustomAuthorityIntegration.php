<?php
/**
 * 管理员自定义权限
 * Date: 2018/12/4
 * Time: 17:52
 */
namespace Admin\Services\Authority\Integration;

use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class OwnerCustomAuthorityIntegration extends BaseWorkProcessor
{
    protected $owner = null;
    protected $role = null;
    protected $checkList = [];

    public function __construct($owner = null, $checkList = [])
    {
        $this->_init($owner, $checkList);
    }

    public function _init($owner, $checkList = [])
    {
        $this->status = 0;
        $checkList = is_array($checkList)? $checkList: [];
        $checkList = array_unique($checkList);
        $this->owner = $owner;
        $this->checkList = $checkList;
        $this->role = null;
        if (isset($owner->role)) {
            $this->role = $this->owner->role;
        }
        return $this;
    }

    protected function parseList($actionList)
    {
        $actionList = is_array($actionList)? $actionList: [];
        $originalList = array_unique($actionList);
        $allowList = array_diff($this->checkList, $originalList);
        $banList = array_diff($originalList, $this->checkList);
        return [$allowList, $banList];
    }

    protected function initUserAction($allowList, $banList)
    {
        $data = [
            'user_id'   =>  $this->owner->user_id,
            'actions'   =>  null,
        ];
        if (!empty($allowList) || !empty($banList)) {
            $allowList = array_values($allowList);
            $banList = array_values($banList);
            $actions = ['allow'=>!empty($allowList)? $allowList: [], 'ban'=>!empty($banList)? $banList: []];
            $data['actions'] = json_encode($actions);
        }
        return $data;
    }

    public function process()
    {
        if (empty($this->role)) {
            return $this->parseResult('无角色', []);
        }
        if (!empty($this->role) && $this->role->role_no != 1) {
            if (!in_array($this->role->index_action, $this->checkList)) {
                return $this->parseResult('角色入口不能取消', []);
            }
        }
        list($status, $message, $roleActionList) = (new RoleAuthoritiesIntegration($this->role))->process();
        list($allowList, $banList) = $this->parseList($roleActionList);
        $data = $this->initUserAction($allowList, $banList);
        $this->status = 1;
        return $this->parseResult('', $data);
    }

}