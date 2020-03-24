<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestRecordLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_record_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('time')->nullable()->default(0)->comment('时间');
            $table->ipAddress('ip');
            $table->integer('user_id')->nullable()->default(0)->comment('用户id')->index();
            $table->string('module', 200)->nullable()->default('');
            $table->string('method', 10)->nullable()->default('');
            $table->string('router', 200)->nullable()->default('');
            $table->integer('exec_time')->nullable()->default(0)->comment('执行时间');
            $table->integer('status')->nullable()->default(0)->comment('状态');
            $table->text('response')->nullable();
            $table->string('user_agent')->nullable()->default('');
            $table->text('header')->nullable();
            $table->text('body_params')->nullable();
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
        Schema::dropIfExists('request_record_logs');
    }
}
