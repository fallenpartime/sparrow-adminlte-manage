<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCultivateCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_courses', function (Blueprint $table) {
            $table->string('name', 50)->after('no')->default('')->comment('开班名称');
            $table->string('description')->after('name')->nullable()->comment('开班简介');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultivate_courses', function (Blueprint $table) {
            $table->dropIndex('cultivate_courses_name_index');
            $table->dropColumn('name');
            $table->dropColumn('description');
        });
    }
}
