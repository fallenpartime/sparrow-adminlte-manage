<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->default(0)->comment('文章类型 1-新闻 2-教育之声 2-工作动态');
            $table->string('title', 255)->default('')->comment('标题');
            $table->string('description', 255)->default('')->comment('文章描述');
            $table->text('content')->nullable()->comment('文章内容');
            $table->string('author', 100)->default('')->comment('作者');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示 0-否 1-是');
            $table->string('list_pic')->nullable()->comment('列表图片地址');
            $table->integer('read_count')->default(0)->comment('阅读数');
            $table->integer('like_count')->default(0)->comment('点赞数');
            $table->timestamp('published_at')->nullable(true)->comment('发布时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index('type');
            $table->index('is_show');
            $table->index('published_at');
            $table->index('author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
