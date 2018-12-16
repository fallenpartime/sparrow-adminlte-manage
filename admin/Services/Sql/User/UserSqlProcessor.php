<?php
/**
 * 用户列表
 * Date: 2018/12/16
 * Time: 22:57
 */
namespace Admin\Services\Sql\User;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class UserSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
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
        // 电话
        $phone = trim(array_get($params, 'phone'));
        if (!empty($phone)) {
            $model = $model->where('phone', $phone);
            $urlParams['phone'] = $phone;
        }
        // 公众号关注状态
        $isSubscribe = intval(array_get($params, 'is_subscribe'));
        if (!empty($isSubscribe)) {
            $subscribeValue = $isSubscribe - 1;
            $model = $model->where('is_subscribe', $subscribeValue);
            $urlParams['is_subscribe'] = $isSubscribe;
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