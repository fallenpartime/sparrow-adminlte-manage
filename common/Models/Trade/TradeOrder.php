<?php
/**
 * 交易订单表
 * Date: 2018/12/9
 * Time: 18:11
 */

namespace Common\Models\Trade;

use Common\Models\BaseModel;
use Common\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradeOrder extends BaseModel
{
    use SoftDeletes;

    protected $table = 'trade_orders';
    protected $appends = ['operate_list', 'status_list'];

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function getStatusListAttribute()
    {
        return array_get($this->attributes, 'status_list', []);
    }

    /**
     * 订单详情
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(TradeInfo::class, 'order_id');
    }

    /**
     * 支付用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}