<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->string('summary', 255)->nullable()->default('');
            $table->string('image', 255)->nullable()->default('');
            $table->text('content')->nullable();
            $table->string('github', 255)->nullable()->default('');
            $table->string('website', 255)->nullable()->default('');
            $table->string('code', 255)->nullable()->default('');
            $table->string('keywords', 255)->nullable()->default('');
            $table->integer('start_time')->nullable()->default(0)->comment('创建时间');
            $table->integer('end_time')->nullable()->default(0)->comment('更新时间');
            $table->boolean('type')->nullable()->default(false)->comment('类型');
            $table->boolean('status')->nullable()->default(false)->comment('状态');
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
        Schema::dropIfExists('projects');
    }
}
