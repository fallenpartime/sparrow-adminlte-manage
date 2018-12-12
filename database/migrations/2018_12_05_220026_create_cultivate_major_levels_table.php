<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateMajorLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_major_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 30)->nullable(false)->comment('等级编号');
            $table->string('name', 100)->nullable(false)->comment('等级名称');
            $table->string('image')->nullable()->comment('等级图片');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
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
        Schema::dropIfExists('cultivate_major_levels');
    }
}
