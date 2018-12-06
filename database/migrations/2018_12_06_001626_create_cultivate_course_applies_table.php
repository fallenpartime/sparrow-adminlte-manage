<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateCourseAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_course_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->string('course_no', 50)->default('')->comment('课程编号');
            $table->integer('info_id')->default(0)->comment('申请信息ID');
            $table->tinyInteger('pay_status')->default(0)->comment('支付状态 0-待支付 1-支付成功 2-支付失败');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->index('course_no');
            $table->index('info_id');
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
        Schema::dropIfExists('cultivate_course_applies');
    }
}
