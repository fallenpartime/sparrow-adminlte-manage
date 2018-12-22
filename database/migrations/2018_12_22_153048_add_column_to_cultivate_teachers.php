<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCultivateTeachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_teachers', function (Blueprint $table) {
            $table->string('face')->nullable(true)->after('birthday')->comment('教师头像');
            $table->text('content')->nullable(true)->after('face')->comment('教师详细介绍');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultivate_teachers', function (Blueprint $table) {
            $table->dropColumn('face');
            $table->dropColumn('content');
        });
    }
}
