<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('auction_id');
            $table->unsignedInteger('user_id');
            $table->integer('price')->default(0);
            $table->timestamp('date_price')->nullable();
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
        Schema::dropIfExists('sale_rates');
    }
}
