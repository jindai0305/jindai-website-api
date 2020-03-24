<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 55)->nullable()->default('')->comment('网站默认title');
            $table->string('description', 255)->nullable()->default('')->comment('说明');
            $table->string('keywords', 120)->nullable()->default('')->comment('默认的关键词');
            $table->string('logo', 255)->nullable()->default('')->comment('logo');
            $table->boolean('repair')->nullable()->default(false)->comment('维护状态');
            $table->string('record', 120)->nullable()->default('')->comment('备案号');
            $table->string('record_url', 255)->nullable()->default('')->comment('备案跳转链接');
            $table->boolean('message')->nullable()->default(false)->comment('留言状态');
            $table->boolean('comment')->nullable()->default(false)->comment('评论状态');
            $table->boolean('chat')->nullable()->default(false)->comment('聊天状态');
            $table->boolean('reward')->nullable()->default(false)->comment('打赏状态');
            $table->string('alipay', 255)->nullable()->default('')->comment('支付宝');
            $table->string('wechat', 255)->nullable()->default('')->comment('微信');
            $table->string('nick_name', 55)->nullable()->default('')->comment('站长昵称');
            $table->string('signature', 120)->nullable()->default('')->comment('签名');
            $table->string('avatar', 255)->nullable()->default('')->comment('站长头像');
            $table->boolean('contact')->nullable()->default(false)->comment('联系我状态');
            $table->boolean('visibility')->nullable()->default(false)->comment('站长信息显示状态');
            $table->text('content')->nullable();
            $table->string('about_title', 55)->nullable()->default('')->comment('关于我标题');
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
        Schema::dropIfExists('settings');
    }
}
