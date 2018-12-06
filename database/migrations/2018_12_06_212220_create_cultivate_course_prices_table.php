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
            $table->tinyInteger('type')->default(0)->comment('定价类型');
            $table->string('no', 30)->default('')->comment('定价编号');
            $table->string('course_no', 30)->default('')->comment('课程编号');
            $table->decimal('train')->default(0)->comment('培训费用');
            $table->decimal('identify')->default(0)->comment('鉴定费用');
            $table->decimal('discount')->default(0)->comment('折扣(实际支付的比例)');
            $table->decimal('sum')->default(0)->comment('总计费用');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('course_no');
            $table->index('discount');
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
