<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBehaviorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behavior_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('url', 200)->nullable()->default('');
            $table->string('method', 10)->nullable()->default('');
            $table->smallInteger('status')->nullable()->default(0);
            $table->text('states')->nullable();
            $table->ipAddress('ip')->nullable()->default('');
            $table->string('agent', 255)->nullable()->default('');
            $table->integer('time')->nullable()->default(0)->comment('创建时间');
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
        Schema::dropIfExists('behavior_logs');
    }
}
