<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserApplyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apply_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->string('name', 50)->default('')->comment('姓名*');
            $table->tinyInteger('gender')->default(0)->comment('性别* 1 男 2 女');
            $table->tinyInteger('card_type')->default(0)->comment('证件类型* 1-身份证 2-军官证 3-护照 4-港澳身份证');
            $table->string('card_no', 30)->default('')->comment('证件号码*');
            $table->string('identity', 100)->default('')->comment('本人身份*');
            $table->date('birthday')->nullable(false)->comment('出生日期*');
            $table->string('phone', 20)->nullable(false)->comment('联系电话*');
            $table->tinyInteger('degree')->default(0)->comment('文化程度*');
            $table->string('school', 50)->default('')->comment('毕业学校');
            $table->string('major', 50)->default('')->comment('专业备注');
            $table->date('graduate_date')->comment('毕业年月');
            $table->string('company', 100)->default('')->comment('工作单位*');
            $table->string('work_lift', 20)->default('')->comment('工作年限');
            $table->string('work_content', 100)->default('')->comment('从事职业');
            $table->string('company_address', 100)->default('')->comment('单位地址');
            $table->tinyInteger('medic_bg')->default(0)->comment('是否有医学背景* 0-否 1-是');
            $table->tinyInteger('medic_agency')->default(0)->comment('是否有医疗机构* 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->index('name');
            $table->index('card_type');
            $table->index('card_no');
            $table->index('birthday');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_apply_infos');
    }
}
