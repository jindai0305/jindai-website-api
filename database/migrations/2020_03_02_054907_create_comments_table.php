<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('item_id')->comment('文章id');
            $table->integer('reply_id')->nullable()->default(-1)->comment('回复的评论id');
            $table->integer('parent_id')->default(0)->comment('顶级评论id');
            $table->text('content')->nullable();
            $table->integer('favor')->nullable()->default(0)->comment('点赞数量');
            $table->boolean('status')->nullable()->default(true)->comment('状态');
            $table->integer('created_at')->nullable()->default(0)->comment('创建时间');
            $table->integer('updated_at')->nullable()->default(0)->comment('更新时间');
            $table->integer('deleted_at')->nullable()->default(0)->comment('删除时间');
            $table->integer('flag')->nullable()->default(0);
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
