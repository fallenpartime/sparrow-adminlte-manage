<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateCourseTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_course_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_no', 30)->default('')->comment('开班编号');
            $table->integer('year')->default(0)->comment('年份');
            $table->string('major_no', 30)->default('')->comment('专业编号');
            $table->string('level_no', 30)->default('')->comment('等级编号');
            $table->string('teacher_no', 30)->default('')->comment('授课人员编号');
            $table->timestamps();
            $table->softDeletes();
            $table->index('course_no');
            $table->index('year');
            $table->index('major_no');
            $table->index('level_no');
            $table->index('teacher_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_course_teachers');
    }
}
