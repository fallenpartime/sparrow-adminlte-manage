<?php
/**
 * 订单详情表
 * Date: 2018/12/9
 * Time: 18:13
 */
namespace Common\Models\Trade;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradeInfo extends BaseModel
{
    use SoftDeletes;

    protected $table = 'trade_infos';

    public function order()
    {
        return $this->belongsTo(TradeOrder::class, 'order_id');
    }
}