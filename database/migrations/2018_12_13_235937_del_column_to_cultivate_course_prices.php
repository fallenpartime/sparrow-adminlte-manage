<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelColumnToCultivateCoursePrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_course_prices', function (Blueprint $table) {
            $table->dropIndex('cultivate_course_prices_level_no_index');
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
        Schema::table('cultivate_course_prices', function (Blueprint $table) {
            $table->string('level_no', 30)->default('')->comment('等级编号');
            $table->index('level_no');
        });
    }
}
