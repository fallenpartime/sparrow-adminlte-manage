<?php
/**
 * 登录
 * Date: 2018/12/1
 * Time: 18:00
 */
namespace App\Http\Admin\Action\Basic;

use Admin\Action\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Config\RedisConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Auth\AuthService;
use Admin\Services\Authority\Integration\OwnerAuthoritiesIntegration;
use Admin\Services\Authority\Processor\AdminUserProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Common\Config\SystemConfig;
use Common\Models\System\AdminUserInfo;
use Wechat\Config\RouteConfig as WechatRouteConfig;
use Frameworks\Tool\Cache\RedisTool;

class LoginAction extends BaseAction
{

    public function run()
    {
        $authService = new AuthService($this->request);
        $authService->destroyLogin();
        $adminDomain = SystemConfig::ADMIN_DOMAIN;
        $currentDomain = url()->current();
        if (str_contains($currentDomain, $adminDomain)) {
            return $this->qrcodeLogin();
        }
        return $this->passwordLogin();
    }

    protected function qrcodeLogin()
    {
        $adminDomain = SystemConfig::ADMIN_DOMAIN;
        $siteDomain = SystemConfig::SITE_DOMAIN;
        $token  = md5(time().rand(100,999));
        $tokenKey = RedisConfig::ADMIN_TOKEN.$token;
        $redisTool = new RedisTool();
        $redisTool->hmset($tokenKey, ['token' => $token, 'site' => RedisConfig::ADMIN_TOKEN_SITE, 'time' => time(), 'status' => 0], 3600);
        $code_url = $siteDomain.route(WechatRouteConfig::ROUTE_OAUTH_ADMIN, ['token'=>$token]);
        $check_url  = $adminDomain.route(RouteConfig::ROUTE_CHECK, ['token'=>$token]);

        $result = [
            'token'     =>  $token,
            'code_url'  =>  $code_url,
            'check_url' =>  $check_url,
        ];
        return view(ViewConfig::LOGIN_QRCODE, $result);
    }

    protected function parseRoleAccess($roleId)
    {
        $accesses = (new AdminUserRoleAccessProcessor())->getListByNo($roleId);
        if (empty($accesses)) {
            return [];
        }
        $list = [];
        foreach ($accesses as $access) {
            $groupNo = $access->group_no;
            $isLeader = $access->is_leader;
            $list[$groupNo] = ['no'=>$groupNo, 'is_leader'=>$isLeader];
        }
        return $list;
    }

    protected function passwordLogin()
    {
        $httpTool = $this->getHttpTool();
        $submit = $httpTool->getBothSafeParam('submit');
        if (empty($submit)) {
            return view(ViewConfig::LOGIN_PASSWORD, []);
        }
        $username = $httpTool->getBothSafeParam('username');
        $pwd = $httpTool->getBothSafeParam('pwd');
        $userProcessor = new AdminUserProcessor();
        $user = $userProcessor->getSingleByName($username);
        if (empty($user)) {
            return view(ViewConfig::LOGIN_PASSWORD, ['result_msg'=>'该用户不存在']);
        }
        if (md5($user->salt.$pwd) == $user->pwd) {
            $userId = $user->id;
            $name = $user->name;
            $owner = AdminUserInfo::with(['user', 'role', 'userAction'])->where('user_id', $userId)->first();
            if (empty($owner)) {
                return view(ViewConfig::LOGIN_PASSWORD, ['result_msg'=>'登录信息不存在']);
            }
            if (!empty($owner) && $owner->is_admin==1) {
                $roleId = $owner->role_id;
                $isManger = $roleId == 1? 1: 0;
                $isSuper = $owner->is_super;
                $ts_list = [];
                if ($roleId > 0) {
                    list($stauts, $message, $ts_list) = (new OwnerAuthoritiesIntegration($owner))->process();
                }
                $groupList = $this->parseRoleAccess($roleId);
                $admin_info = array(
                    'userid' 	=> $userId,
                    'username'	=> $name,
                    'role_id'	=> $roleId,
                    'group_list'    => $groupList,
                    'is_manager'    => $isManger,
                    'is_super'  => $isSuper,
                );
                $httpTool->setSession(AdminConfig::ADMIN_INFO, $admin_info);
                $httpTool->setSession(AdminConfig::ADMIN_TS_LIST, $ts_list);
                header("location: ".route(RouteConfig::ROUTE_INDEX));
            }
            return view(ViewConfig::LOGIN_PASSWORD, ['result_msg'=>'用户不允许登录']);
        }
        return view(ViewConfig::LOGIN_PASSWORD, ['result_msg'=>'用户账号密码不正确']);
    }
}