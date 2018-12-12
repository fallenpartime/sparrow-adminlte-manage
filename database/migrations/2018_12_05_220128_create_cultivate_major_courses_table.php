<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateMajorCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_major_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 30)->nullable(false)->comment('课程编号');
            $table->string('major_no', 30)->nullable(false)->comment('专业编号');
            $table->tinyInteger('type')->default(0)->comment('课程类型 1-理论 2-实践');
            $table->string('name', 100)->nullable(false)->comment('课程名称');
            $table->string('description', 1000)->nullable(false)->default('')->comment('课程简介');
            $table->string('image')->nullable()->comment('课程图片');
            $table->integer('order')->default(0)->comment('排序序号');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('major_no');
            $table->index('type');
            $table->index('name');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_major_courses');
    }
}
