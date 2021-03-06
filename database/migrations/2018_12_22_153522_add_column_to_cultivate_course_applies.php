<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCultivateCourseApplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_course_applies', function (Blueprint $table) {
            $table->string('remark')->after('info_id')->default('')->commit('申请备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultivate_course_applies', function (Blueprint $table) {
            $table->dropColumn('remark');
        });
    }
}
