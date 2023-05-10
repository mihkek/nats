<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_workers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id');
            $table->string('name')->default('');
            $table->string('position')->default('');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('order')->default(0);

            /*
            $table->foreign('office_id')
                ->references('offices')->on('id')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_workers');
    }
}
