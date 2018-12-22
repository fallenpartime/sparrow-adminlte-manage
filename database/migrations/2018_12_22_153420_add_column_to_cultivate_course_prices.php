<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCultivateCoursePrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivate_course_prices', function (Blueprint $table) {
            $table->string('title', 100)->comment('报价标题');
            $table->string('title')->comment('报价标题');
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
            //
        });
    }
}
