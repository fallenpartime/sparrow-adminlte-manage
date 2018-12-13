<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelColumnToCultivateCourseTeachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_course_teachers', function (Blueprint $table) {
            $table->dropIndex('cultivate_course_teachers_year_index');
            $table->dropIndex('cultivate_course_teachers_major_no_index');
            $table->dropIndex('cultivate_course_teachers_level_no_index');
            $table->dropColumn('year');
            $table->dropColumn('major_no');
            $table->dropColumn('level_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultivate_course_teachers', function (Blueprint $table) {
            $table->integer('year')->after('course_no')->default(0)->comment('年份');
            $table->string('major_no', 30)->after('major_no')->default('')->comment('专业编号');
            $table->string('level_no', 30)->after('level_no')->default('')->comment('等级编号');
            $table->index('year');
            $table->index('major_no');
            $table->index('level_no');
        });
    }
}
