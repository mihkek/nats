<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersOrgToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_org_to_user', function (Blueprint $table) {
            $table->unsignedInteger('org_id');
            $table->integer('user_id');
            $table->primary(['user_id', 'org_id']);

            $table->foreign('org_id')
                ->references('id')
                ->on('users_org')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('users_org_to_user');
    }
}
