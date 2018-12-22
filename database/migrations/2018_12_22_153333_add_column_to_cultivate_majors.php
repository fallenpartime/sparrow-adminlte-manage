<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCultivateMajors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_majors', function (Blueprint $table) {
            $table->text('content')->comment('专业详细介绍');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultivate_majors', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
}
