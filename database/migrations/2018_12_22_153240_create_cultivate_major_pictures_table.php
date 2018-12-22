<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateMajorPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_major_pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('major_id')->nullable(false)->default(0)->comment('专业ID');
            $table->tinyInteger('type')->default(0)->comment('类型 1-列表图片');
            $table->string('pic')->nullable(true)->comment('图片地址');
            $table->tinyInteger('del_status')->default(0)->comment('作废处理状态 0-未处理 1-已处理');
            $table->timestamps();
            $table->index('major_id');
            $table->index('type');
            $table->index('del_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_major_pictures');
    }
}
