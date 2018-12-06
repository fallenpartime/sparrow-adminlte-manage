<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 30)->default('')->comment('开班编号');
            $table->integer('year')->default(0)->comment('年份');
            $table->string('major_no', 30)->default('')->comment('专业编号');
            $table->string('level_no', 30)->default('')->comment('等级编号');
            $table->string('price_no', 30)->default('')->comment('定价编号');
            $table->decimal('price')->default(0)->comment('定价');
            $table->decimal('pay_price')->default(0)->comment('实际需支付金额');
            $table->integer('num')->default(0)->comment('开班个数');
            $table->timestamp('start_at')->nullable()->comment('开班时间');
            $table->timestamp('over_at')->nullable()->comment('结束时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('year');
            $table->index('major_no');
            $table->index('level_no');
            $table->index('price_no');
            $table->index('price');
            $table->index('num');
            $table->index('start_at');
            $table->index('over_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_courses');
    }
}
