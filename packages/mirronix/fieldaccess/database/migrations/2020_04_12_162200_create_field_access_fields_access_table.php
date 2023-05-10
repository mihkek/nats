<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldAccessFieldsAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_access_fields_access', function (Blueprint $table) {
            $table->integer('role_id')->default(0);
            $table->string('model', 160)->default('');
            $table->string('field', 32)->default('');
            $table->enum('access', ['disabled', 'read', 'write'])->default('write');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_access_fields_access');
    }
}
