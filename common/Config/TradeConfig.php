<?php
/**
 * 交易配置
 * Date: 2018/12/15
 * Time: 23:27
 */
namespace Common\Config;

class TradeConfig
{
    const ORDER_APPLY_TYPE = 1;
    const PAY_WECHAT_TYPE  = 1;
    const PAY_UNION_TYPE   = 2;

    /**
     * 订单类型
     * @return array
     */
    public static function getOrderType()
    {
        return [
            self::ORDER_APPLY_TYPE  =>  ['name' => '报名'],
        ];
    }

    /**
     * 支付类型
     * @return array
     */
    public static function getPayType()
    {
        return [
            self::PAY_WECHAT_TYPE   =>  ['name' => '微信'],
            self::PAY_UNION_TYPE    =>  ['name' => '银联'],
        ];
    }
}