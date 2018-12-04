<?php
/**
 * 日志工具
 * Date: 2018/12/1
 * Time: 16:41
 */
namespace Admin\Tool;

use Admin\Services\Auth\AuthService;
use Admin\Services\Log\LogService;

class LogTool
{
    protected $request = null;
    protected $adminInfo = null;

    public function __construct($request, $adminInfo = null)
    {
        $this->request = $request;
        $this->_init($adminInfo);
    }

    public function _init($adminInfo)
    {
        $this->adminInfo = $adminInfo;
        return $this;
    }

    protected function getAdminInfo()
    {
        if (empty($this->adminInfo)) {
            $this->adminInfo = (new AuthService($this->request))->getAdminInfo();
        }
        return $this->adminInfo;
    }

    /**
     * 业务日志
     * @param $operateType
     * @param $objectId
     * @param $memo
     */
    public function operateLog($operateType, $objectId, $memo = '')
    {
        LogService::operateLog($this->request, $operateType, $objectId, $memo, $this->getAdminInfo());
    }

    /**
     * 系统日志
     * @param $operateType
     * @param $objectId
     * @param $memo
     */
    public function adminLog($operateType, $objectId, $memo = '')
    {
        LogService::adminLog($this->request, $operateType, $objectId, $memo, $this->getAdminInfo());
    }
}