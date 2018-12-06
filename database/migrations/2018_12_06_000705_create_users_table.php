<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivate_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nick_name', 100)->default('')->comment('用户昵称');
            $table->string('openid', 100)->default('')->comment('openid');
            $table->string('unionid')->default('')->comment('unionid');
            $table->string('phone', 30)->default('')->comment('用户电话');
            $table->string('face')->default('')->comment('用户头像');
            $table->tinyInteger('is_subscribe')->default(0)->comment('是否关注 0-否 1-是');
            $table->timestamp('subscribed_at')->nullable(true)->comment('关注时间');
            $table->timestamp('last_login_at')->nullable(true)->comment('最后登录时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index('nick_name');
            $table->index('openid');
            $table->index('phone');
            $table->index('is_subscribe');
            $table->index('subscribed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivate_users');
    }
}
