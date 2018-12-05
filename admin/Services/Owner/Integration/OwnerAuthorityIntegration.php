<?php
/**
 * 保存用户权限
 * Date: 2018/12/4
 * Time: 20:18
 */
namespace Admin\Services\Owner\Integration;

use Admin\Services\Authority\Processor\AdminUserActionProcessor;
use Admin\Services\Log\LogService;
use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class OwnerAuthorityIntegration extends BaseWorkProcessor
{
    protected $request = null;
    protected $owner = null;
    protected $userAction = null;
    protected $data = [];

    public function __construct($request, $owner, $data)
    {
        $this->request = $request;
        $this->owner = $owner;
        if (!empty($owner)) {
            $this->userAction = $owner->userAction;
        }
        $this->data = $data;
    }

    protected function store()
    {
        list($res, $model) = (new AdminUserActionProcessor())->insert($this->data);
        LogService::adminLog($this->request, 3, $model->id, '编辑管理员权限');
        $insertId = $res? $model->id: 0;
        return [$res, $insertId];
    }

    protected function update()
    {
        LogService::adminLog($this->request, 3, $this->userAction->id, '编辑管理员权限');
        return (new AdminUserActionProcessor())->update($this->userAction->id, $this->data);
    }

    public function process()
    {
        if (empty($this->owner)) {
            return $this->parseResult('无用户');
        }
        if (empty($this->data)) {
            return $this->parseResult('数据为空');
        }
        if (empty($this->userAction)) {
            list($res, $modelId) = $this->store();
        } else {
            list($res, $modelId) = $this->update();
        }
        $this->status = $res? 1: 0;
        return $this->parseResult();
    }
}