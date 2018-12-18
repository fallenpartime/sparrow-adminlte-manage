<?php
/**
 * 订单列表
 * Date: 2018/12/18
 * Time: 12:48
 */
namespace Admin\Services\Sql\Trade\Order;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class OrderSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        // 昵称
        $nickName = trim(array_get($params, 'nick_name'));
        if (!empty($nickName)) {
            $model = $model->where('nick_name', $nickName);
            $urlParams['nick_name'] = $nickName;
        }
        // 用户ID
        $userId = intval(trim(array_get($params, 'user_id')));
        if ($userId > 0) {
            $model = $model->where('user_id', $userId);
            $urlParams['user_id'] = $userId;
        }
        // 电话
        $phone = trim(array_get($params, 'phone'));
        if (!empty($phone)) {
            $model = $model->where('phone', $phone);
            $urlParams['phone'] = $phone;
        }
        // 订单类型
        $type = intval(array_get($params, 'type'));
        if (!empty($type)) {
            $model = $model->where('type', $type);
            $urlParams['type'] = $type;
        }
        // 支付类型
        $payType = intval(array_get($params, 'pay_type'));
        if (!empty($payType)) {
            $model = $model->where('pay_type', $payType);
            $urlParams['pay_type'] = $payType;
        }
        // 支付状态
        $payStatus = intval(array_get($params, 'pay_status'));
        if ($payStatus > 0) {
            $statusValue = $payStatus - 1;
            $model = $model->where('pay_status', $statusValue);
            $urlParams['pay_status'] = $payStatus;
        }
        // 订单号
        $orderNo = array_get($params, 'order_no');
        if (!empty($orderNo)) {
            $model = $model->where('order_no', $orderNo);
            $urlParams['order_no'] = $orderNo;
        }
        // 支付单号
        $outTradeNo = array_get($params, 'out_trade_no');
        if (!empty($outTradeNo)) {
            $model = $model->where('out_trade_no', $outTradeNo);
            $urlParams['out_trade_no'] = $outTradeNo;
        }
        // 订单金额
        $orderMoney = array_get($params, 'order_money');
        if (!empty($orderMoney)) {
            $model = $model->where('order_money', $orderMoney);
            $urlParams['order_money'] = $orderMoney;
        }
        // 支付金额
        $moneyPayed = array_get($params, 'money_payed');
        if (!empty($moneyPayed)) {
            $model = $model->where('money_payed', $moneyPayed);
            $urlParams['money_payed'] = $moneyPayed;
        }
        // 需支付金额
        $realMoney = array_get($params, 'real_money');
        if (!empty($realMoney)) {
            $model = $model->where('real_money', $realMoney);
            $urlParams['real_money'] = $realMoney;
        }
        // 开始时间
        $fromTime = trim(array_get($params, 'from_time'));
        if (!empty($fromTime)) {
            $model = $model->where('created_at', '>=', $fromTime);
            $urlParams['from_time'] = $fromTime;
        }
        // 结束时间
        $endTime = trim(array_get($params, 'end_time'));
        if (!empty($endTime)) {
            $model = $model->where('created_at', '<=', $endTime);
            $urlParams['end_time'] = $endTime;
        }
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}