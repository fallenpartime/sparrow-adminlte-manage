<?php
/**
 * 申请列表
 * Date: 2018/12/17
 * Time: 0:10
 */
namespace Admin\Services\Sql\User\apply;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class UserApplySqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{

    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        // 昵称
        $nickName = trim(array_get($params, 'nick_name'));
        // 用户ID
        $userId = intval(trim(array_get($params, 'user_id')));
        // 电话
        $phone = trim(array_get($params, 'phone'));
        if (!empty($nickName) || !empty($userId) || !empty($phone)) {
            $urlParams['nick_name'] = $nickName;
            $urlParams['user_id'] = $userId;
            $urlParams['phone'] = $phone;
            $model = $model->whereHas('user', function ($query) use ($urlParams) {
                if (!empty($urlParams['user_id'])) {
                    $query->where('id', $urlParams['user_id']);
                }
                if (!empty($urlParams['nick_name'])) {
                    $query->where('nick_name', $urlParams['nick_name']);
                }
                if (!empty($urlParams['phone'])) {
                    $query->where('phone', $urlParams['phone']);
                }
            });
        }
        // 开班编号
        $courseNo = trim(array_get($params, 'course_no'));
        if (!empty($courseNo)) {
            $model = $model->where('course_no', $courseNo);
            $urlParams['course_no'] = $courseNo;
        }
        // 申请人姓名
        $applyName = trim(array_get($params, 'apply_name'));
        if (!empty($applyName)) {
            $urlParams['apply_name'] = $applyName;
            $model = $model->whereHas('applyInfo', function ($query) use ($urlParams) {
                if (!empty($urlParams['apply_name'])) {
                    $query->where('name', $urlParams['apply_name']);
                }
            });
        }
        // 支付状态
        $payStatus = intval(array_get($params, 'pay_status'));
        if (!empty($payStatus)) {
            $payValue = $payStatus - 1;
            $model = $model->where('pay_status', $payValue);
            $urlParams['pay_status'] = $payStatus;
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