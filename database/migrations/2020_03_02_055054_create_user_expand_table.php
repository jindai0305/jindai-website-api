<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExpandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_expand', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nick_name', 36)->nullable()->default('');
            $table->text('avatar')->nullable();
            $table->string('website', 500)->nullable()->default('');
            $table->string('signature', 50)->nullable()->default('');
            $table->integer('active_at')->nullable()->default(0)->comment('活跃时间');
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
        Schema::dropIfExists('user_expand');
    }
}
