<?php
/**
 * 课程定价表
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateCoursePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_course_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default(0)->comment('定价类型');
            $table->string('no', 30)->default('')->comment('等级编号');
            $table->string('level_no', 30)->default('')->comment('');
            $table->string('course_no', 30)->default('')->comment('课程编号');
            $table->decimal('train')->default(0)->comment('培训费用');
            $table->decimal('identify')->default(0)->comment('鉴定费用');
            $table->decimal('discount')->default(0)->comment('折扣(实际支付的比例)');
            $table->decimal('money')->default(0)->comment('总计费用');
            $table->decimal('real_money')->default(0)->comment('实际需支付金额');
            $table->tinyInteger('active_status')->default(0)->comment('是否激活 0-否 1-是');
            $table->tinyInteger('used_status')->default(0)->comment('是否使用过 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('level_no');
            $table->index('course_no');
            $table->index('discount');
            $table->index('money');
            $table->index('real_money');
            $table->index('active_status');
            $table->index('used_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_course_prices');
    }
}
