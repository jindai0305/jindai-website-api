<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 150);
            $table->string('summary', 450)->nullable()->default('');
            $table->integer('cate_id')->comment('分类id');
            $table->string('image', 255)->nullable()->default('');
            $table->string('keywords', 120)->nullable()->default('');
            $table->text('content')->nullable();
            $table->boolean('type')->nullable()->default(false)->comment('类型');
            $table->boolean('allow_comment')->nullable()->default(true)->comment('允许评论');
            $table->boolean('copyright')->nullable()->default(false)->comment('是否原创');
            $table->string('original_website', 55)->nullable()->default('');
            $table->string('original_link', 255)->nullable()->default('');
            $table->boolean('chosen')->nullable()->default(false)->comment('是否精选');
            $table->boolean('status')->nullable()->default(false)->comment('状态');
            $table->integer('view_nums')->nullable()->default(0)->comment('浏览数量');
            $table->integer('approve_nums')->nullable()->default(0)->comment('点赞数');
            $table->integer('collect_nums')->nullable()->default(0)->comment('收藏数');
            $table->integer('comment_nums')->nullable()->default(0)->comment('评论数');
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
        Schema::dropIfExists('items');
    }
}
