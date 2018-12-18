<?php
/**
 * 交易订单列表
 * Date: 2018/12/5
 * Time: 17:05
 */
namespace App\Http\Admin\Action\Trade\Order;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Trade\Order\OrderSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Config\TradeConfig;
use Common\Models\Trade\TradeOrder;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_TRADE_ORDER_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new OrderSqlProcessor())->getListSql(new TradeOrder(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->select(['id', 'type', 'pay_type', 'nick_name', 'user_id', 'phone', 'face', 'order_no', 'order_no', 'out_trade_no', 'order_money', 'real_money', 'money_payed', 'pay_status', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'orderTypeList' => TradeConfig::getOrderType(),
            'payTypeList'   => TradeConfig::getPayType(),
            'payStatusList' => TradeConfig::getPayStatusType(),
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_TRADE_ORDER_LIST),
        ];
        return $this->createView(ViewConfig::TRADE_ORDER_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_TRADE, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_TRADE_ORDER, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_TRADE_ORDER_LIST, 'url' => 0, 'active' => 1],
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
        $statusList = [
            'pay_status'=>'',
            'order_type'=>'',
            'pay_type'=>'',
        ];
        $order = $list[$key];
        $payStatus = $order->pay_status;
        $type = $order->type;
        $payType = $order->pay_type;
        $statusValue = $payStatus + 1;
        $statusMap = TradeConfig::getPayStatusType();
        $payTypeMap = TradeConfig::getPayType();
        $orderTypeMap = TradeConfig::getOrderType();
        if (isset($statusMap[$statusValue])) {
            $statusList['pay_status'] = $statusMap[$statusValue]['name'];
        }
        if (isset($payTypeMap[$payType])) {
            $statusList['pay_type'] = $payTypeMap[$payType]['name'];
        }
        if (isset($orderTypeMap[$type])) {
            $statusList['order_type'] = $orderTypeMap[$type]['name'];
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
//        $authService = $this->getAuthService();
//        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_USER_APPLY_LIST)) {
//            $operateList['allow_apply'] = 1;
//            $operateUrl['apply_url'] = route(RouteConfig::ROUTE_USER_APPLY_LIST);
//        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_check_apply' => 0,
        ];
//        $authService = $this->getAuthService();
//        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_USER_APPLY_LIST)) {
//            $operateList['allow_operate_check_apply'] = 1;
//        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}