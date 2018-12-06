<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->default(0)->comment('订单ID');
            $table->tinyInteger('type')->default(0)->comment('交易类型 1-报名');
            $table->integer('apply_id')->default(0)->comment('申请ID');
            $table->timestamps();
            $table->softDeletes();
            $table->index('order_id');
            $table->index('type');
            $table->index('apply_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_infos');
    }
}
