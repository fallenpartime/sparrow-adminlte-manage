<?php
/**
 * 后台验证
 * Date: 2018/10/2
 * Time: 22:39
 */
namespace Admin\Services\Auth;

use Admin\Config\AdminConfig;
use Admin\Config\RouteConfig;
use Frameworks\Tool\CompareTool;
use Frameworks\Tool\Http\SessionTool;
use Illuminate\Http\Request;

class AuthService
{
    protected $request = null;
    protected $adminInfo = [];
    protected $actionList = [];
    protected $currentAction = '';
    protected $session = null;
    public $isMaster = 0;
    public $isSuper = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_init($request);
    }

    protected function _clear()
    {
        $this->adminInfo = [];
        $this->actionList = [];
        $this->currentAction = '';
        $this->isMaster = 0;
        $this->isSuper = 0;
    }

    protected function _init(Request $request)
    {
        $this->_clear();
        $this->session = new SessionTool($request);
        $this->currentAction = $request->route()->getName();
        $this->initAdminInfo();
        $this->initActionList();
    }

    protected function initAdminInfo()
    {
        $this->adminInfo = $this->session->get(AdminConfig::ADMIN_INFO);
        if (AdminConfig::getAnalogAdminLogin() && empty($this->adminInfo)) {
            // TODO: 测试环境
            $this->adminInfo = array(
                'userid' 	=> 1,
                'username'	=> 'adminc',
                'role_id'	=> 1,
                'group_list'    => ['1'=>['no'=>1, 'is_leader'=>0]],
                'is_manager'    => 1,
                'is_super'  => 1,
            );
        }
        $this->isMaster = $this->adminInfo['is_manager'];
        $this->isSuper = $this->adminInfo['is_super'];
    }

    protected function initActionList()
    {
        $this->actionList = $this->session->get(AdminConfig::ADMIN_TS_LIST);
    }

    public function getAdminInfo()
    {
        return $this->adminInfo;
    }

    public function getActionList()
    {
        return $this->actionList;
    }

    public function validateLogin()
    {
        $loginStatus = false;
        $redirectUrl = route(RouteConfig::ROUTE_LOGIN);
        if (!empty($this->adminInfo)) {
            $loginStatus = true;
        } else {
            if ($this->request->ajax()) {
                $result = [
                    'code'  =>  500,
                    'msg'   =>  '请先登录'
                ];
                exit(json_encode($result));
            }
        }
        return [$loginStatus, $redirectUrl, $this->adminInfo];
    }

    public function validateCurrentAction()
    {
        if (AdminConfig::getAnalogAdminLogin()) {
            // TODO: 测试环境
            return [true, ''];
        }
        list($status, $redirectUrl, $adminInfo) = $this->validateLogin();
        if (empty($status)) {
            return [false, redirect($redirectUrl)];
        }
        if ($this->isMaster) {
            return [true, ''];
        }
        $validate = $this->validateAction($this->currentAction);
        if ($validate) {
            return [true, ''];
        }
        if ($this->request->ajax()) {
            $result = [
                'code'  =>  500,
                'msg'   =>  '权限不足'
            ];
            exit(json_encode($result));
        }
        $redirectUrl = route(RouteConfig::ROUTE_WARN);
        return [false, redirect($redirectUrl)];
    }

    /**
     * 对比操作
     * @param $action
     * @param $method 0-or 1-and
     * @return bool
     */
    public function validateAction($action, $method = 1)
    {
        if (empty($action)) {
            return false;
        }
        $actionList = $this->actionList;
        if (empty($actionList)) {
            return false;
        }
        if (is_array($action)) {
            return CompareTool::compareValues($method, CompareTool::METHOD_IN_ARRAY, $action, $actionList);
        }
        return in_array($action, $actionList);
    }

    /**
     * 注销登录session 销毁
     * @return bool
     */
    public function destroyLogin()
    {
        $this->session->remove(AdminConfig::ADMIN_INFO);
        $this->session->remove(AdminConfig::ADMIN_TS_LIST);
        return true;
    }
}