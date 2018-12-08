<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->default(0)->comment('订单类型 1-报名费用');
            $table->tinyInteger('pay_type')->default(0)->comment('支付类型 1-微信支付 2-银联支付');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->string('nick_name', 100)->default('')->comment('用户昵称');
            $table->string('phone', 30)->default('')->comment('用户电话');
            $table->string('face')->default('')->comment('用户头像');
            $table->string('order_no', 100)->default('')->comment('订单编号');
            $table->tinyInteger('account_id')->default(0)->comment('收款账号ID');
            $table->string('out_trade_no', 180)->default('')->comment('下单编号');
            $table->string('transaction_id', 50)->default('')->comment('支付接口流水号');
            $table->string('payrandstr')->default('')->comment('调用支付接口时产生的随机字符串，用于回调时验证');
            $table->string('openid', 180)->default('');
            $table->string('unionid', 180)->default('');
            $table->decimal('order_money')->default(0)->comment('订单金额');
            $table->decimal('real_money')->default(0)->comment('订单许支付金额');
            $table->decimal('money_payed')->default(0)->comment('实际支付金额');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->timestamp('notify_time')->nullable()->comment('回调时间');
            $table->tinyInteger('pay_status')->default(0)->comment('支付状态 0-待支付 1-已支付 2-待回调 3-支付失败');
            $table->timestamps();
            $table->softDeletes();
            $table->index('type');
            $table->index('pay_type');
            $table->index('user_id');
            $table->index('phone');
            $table->index('order_no');
            $table->index('account_id');
            $table->index('out_trade_no');
            $table->index('transaction_id');
            $table->index('openid');
            $table->index('order_money');
            $table->index('real_money');
            $table->index('money_payed');
            $table->index('pay_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_orders');
    }
}
