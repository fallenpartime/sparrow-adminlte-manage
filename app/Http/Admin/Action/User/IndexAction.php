<?php
/**
 * 用户列表
 * Date: 2018/12/9
 * Time: 17:42
 */
namespace App\Http\Admin\Action\User;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\User\UserSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\User\User;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_USER_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new UserSqlProcessor())->getListSql(new User(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->select(['id', 'nick_name', 'phone', 'face', 'is_subscribe', 'subscribed_at', 'last_login_at', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_USER_LIST),
        ];
        return $this->createView(ViewConfig::USER_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_USER_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_USER, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_USER_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list = $this->initStatusList($list, $key);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function initStatusList($list, $key)
    {
        $statusList = ['subscribe_status'=>''];
        $article = $list[$key];
        $isSubscribe = $article->is_subscribe;
        if ($isSubscribe) {
            $statusList['subscribe_status'] = '已关注';
        } else {
            $statusList['subscribe_status'] = '未关注';
        }
        $list[$key]['status_list'] = $statusList;
        return $list;

    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_apply' => 0,
        ];
        $operateUrl = [
            'apply_url'     => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_USER_APPLY_LIST)) {
            $operateList['allow_apply'] = 1;
            $operateUrl['apply_url'] = route(RouteConfig::ROUTE_USER_APPLY_LIST);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_check_apply' => 0,
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_USER_APPLY_LIST)) {
            $operateList['allow_operate_check_apply'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}