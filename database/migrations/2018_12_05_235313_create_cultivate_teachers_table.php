<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 30)->default('')->comment('教师编号');
            $table->string('name', 30)->default('')->comment('姓名');
            $table->string('description', 500)->default('')->comment('简介');
            $table->tinyInteger('sex')->default(0)->comment('性别 1-男 2-女');
            $table->tinyInteger('age')->default(0)->comment('年龄');
            $table->tinyInteger('positional')->default(0)->comment('职称 1-讲师');
            $table->tinyInteger('diploma')->default(0)->comment('学历 1-中专 2-大专 3-本科 4-硕士 5-博士');
            $table->tinyInteger('degree')->default(0)->comment('学位 1-学士');
            $table->tinyInteger('duty')->default(0)->comment('是否兼职 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('no');
            $table->index('name');
            $table->index('sex');
            $table->index('age');
            $table->index('positional');
            $table->index('diploma');
            $table->index('degree');
            $table->index('duty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_teachers');
    }
}
