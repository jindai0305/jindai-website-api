<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 25);
            $table->boolean('status')->nullable()->default(true)->comment('状态');
            $table->integer('created_at')->nullable()->default(0)->comment('创建时间');
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
        Schema::dropIfExists('cates');
    }
}
