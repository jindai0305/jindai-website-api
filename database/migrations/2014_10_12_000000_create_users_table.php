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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('confirm_code', 64)->comment('唯一验证码');
            $table->integer('email_verified_at')->nullable()->default(0);
            $table->string('password', 255);
            $table->boolean('is_super')->nullable()->default(false)->comment('是否为超级管理员');
            $table->integer('score')->nullable()->default(0)->comment('分数');
            $table->rememberToken();
            $table->integer('created_at')->nullable()->default(0)->comment('创建时间');
            $table->integer('updated_at')->nullable()->default(0)->comment('更新时间');
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
        Schema::dropIfExists('users');
    }
}
