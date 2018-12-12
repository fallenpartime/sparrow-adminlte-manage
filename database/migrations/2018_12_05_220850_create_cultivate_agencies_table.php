<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 30)->nullable(false)->comment('机构编号');
            $table->tinyInteger('type')->default(0)->comment('机构类型 1-培训机构');
            $table->string('name', 100)->nullable(false)->comment('机构名称');
            $table->string('description', 1000)->nullable(false)->comment('机构简介');
            $table->string('logo')->nullable()->comment('机构logo');
            $table->string('address')->nullable(false)->default('')->comment('地址');
            $table->string('phone', 30)->nullable(false)->default('')->comment('联系电话');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('type');
            $table->index('name');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_agencies');
    }
}
