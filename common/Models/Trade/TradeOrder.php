<?php
/**
 * 交易订单表
 * Date: 2018/12/9
 * Time: 18:11
 */

namespace Common\Models\Trade;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradeOrder extends BaseModel
{
    use SoftDeletes;

    protected $table = 'trade_orders';
}