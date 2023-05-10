<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoomConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderer_zoom_conferences', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('orderer_id')->unsigned();
            $table->string('conference_id');
            $table->text('url_start');
            $table->text('url_join');

            $table->foreign('orderer_id')
                ->references('id')
                ->on('orderers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderer_zoom_conferences');
    }
}
