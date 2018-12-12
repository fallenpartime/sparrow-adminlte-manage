<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateMajorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_majors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 30)->nullable(false)->comment('专业编号');
            $table->tinyInteger('type')->default(0)->comment('专业类型');
            $table->string('name', 100)->nullable(false)->comment('专业名称');
            $table->string('description', 1000)->nullable(false)->default('')->comment('专业简介');
            $table->string('image')->nullable()->comment('专业图片');
            $table->integer('order')->default(0)->comment('排序序号');
            $table->tinyInteger('show_status')->default(0)->comment('是否显示 0-否 1-是');
            $table->tinyInteger('is_recommend')->default(0)->comment('是否推荐专业 0-否 1-是');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热点专业 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('type');
            $table->index('name');
            $table->index('order');
            $table->index('show_status');
            $table->index('is_recommend');
            $table->index('is_hot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_majors');
    }
}
