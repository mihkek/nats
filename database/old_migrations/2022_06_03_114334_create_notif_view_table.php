<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notif_view', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rateId');
            $table->unsignedBigInteger('userId');
            $table->integer('type');
            $table->string('onDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notif_view');
    }
}

