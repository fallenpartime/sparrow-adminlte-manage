<?php
/**
 *
 * Date: 2018/12/15
 * Time: 23:24
 */
namespace App\Http\Admin\Action\User\apply;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\User\apply\UserApplySqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateCourseApply;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_USER_APPLY_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new UserApplySqlProcessor())->getListSql(new CultivateCourseApply(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with(['user', 'course', 'applyInfo'])->select(['id', 'user_id', 'course_no', 'info_id', 'pay_status', 'created_at'])->get();
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
            'redirectUrl'   => route(RouteConfig::ROUTE_USER_APPLY_LIST),
        ];
        return $this->createView(ViewConfig::USER_APPLY_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_USER_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_USER_APPLY, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_USER_APPLY_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list = $this->initStatusList($list, $key);
//            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function initStatusList($list, $key)
    {
        $statusList = ['pay_status'=>''];
        $article = $list[$key];
        $payStatus = $article->pay_status;
        switch ($payStatus) {
            case 0:
                $statusList['pay_status'] = '待支付';
                break;
            case 1:
                $statusList['pay_status'] = '支付成功';
                break;
            case 2:
                $statusList['pay_status'] = '支付失败';
                break;
        }
        $list[$key]['status_list'] = $statusList;
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_remove' => 0,
        ];
        $operateUrl = [
            'remove_url' => '',
        ];
//        $authService = $this->getAuthService();
//        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_TEACHER_REMOVE)) {
//            $operateList['allow_remove'] = 1;
//            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_TEACHER_REMOVE);
//        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_remove' => 0
        ];
//        $authService = $this->getAuthService();
//        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_TEACHER_EDIT)) {
//            $operateList['allow_operate_edit'] = 1;
//        }
//        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_TEACHER_REMOVE)) {
//            $operateList['allow_operate_remove'] = 1;
//        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}