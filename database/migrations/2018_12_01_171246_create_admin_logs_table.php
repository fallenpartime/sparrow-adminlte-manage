<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->integer('operate_type')->default(0)->comment('操作类型');
            $table->bigInteger('object_id')->default(0)->comment('操作对象ID');
            $table->string('memo', 1000)->default('')->comment('备注');
            $table->string('ip', 30)->default('')->comment('ip');
            $table->timestamps();
            $table->index('user_id');
            $table->index('operate_type');
            $table->index('object_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
}
