<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('metro_station_id')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('requisites')->nullable();

            /*
            $table->foreign('city_id')
                ->references('cities')->on('id')
                ->onDelete('cascade');
            $table->foreign('metro_station_id')
                ->references('metro_stations')->on('id')
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
        Schema::dropIfExists('offices');
    }
}
