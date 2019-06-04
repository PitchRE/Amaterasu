<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('discord_id');
            $table->bigInteger('item_id')->unsigned();
            $table->integer('count')->unsigned()->default(1);
            $table->timestamps();
        });

        Schema::table('user_items', function ($table) {
            $table->foreign('discord_id')->references('discord_id')->on('users');
        });

        Schema::table('user_items', function ($table) {
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_items');
    }
}