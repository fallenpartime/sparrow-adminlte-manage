<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateAgencyPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_agency_pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('agency_id')->default(0)->comment('机构ID');
            $table->tinyInteger('type')->default(0)->comment('类型 1-列表图片');
            $table->string('pic')->comment('图片地址');
            $table->tinyInteger('del_status')->default(0)->comment('作废处理状态 0-未处理 1-已处理');
            $table->timestamps();
            $table->softDeletes();
            $table->index('agency_id');
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
        Schema::dropIfExists('cultivate_agency_pictures');
    }
}
