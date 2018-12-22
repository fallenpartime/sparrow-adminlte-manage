<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position')->default(0)->comment('定位 1-首页');
            $table->tinyInteger('type')->default(0)->comment('类型 1-图片 2-文字');
            $table->string('title', 100)->nullable(true)->comment('标题');
            $table->string('address')->nullable(true)->comment('地址');
            $table->string('content')->nullable(true)->comment('内容');
            $table->string('url')->nullable(true)->comment('链接地址');
            $table->string('description')->nullable(true)->comment('描述');
            $table->integer('order_index')->default(0)->comment('排序');
            $table->timestamps();
            $table->softDeletes();
            $table->index('position');
            $table->index('type');
            $table->index('order_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertises');
    }
}
