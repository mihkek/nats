<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogGlobalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_global', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('created')->nullable();
            $table->string('model')->default('');
            $table->string('model_id', 32)->default('');
            $table->integer('user_id')->default(0);
            $table->string('field')->default('');
            $table->text('old_value')->default('');
            $table->text('new_value')->default('');
            $table->index(['model', 'model_id'], 'model_lookup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_global');
    }
}

