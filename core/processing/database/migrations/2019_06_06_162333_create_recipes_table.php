<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('item_1')->unsigned();
            $table->bigInteger('item_2')->unsigned();
            $table->bigInteger('item_3')->unsigned()->nullable();
            $table->bigInteger('item_4')->unsigned()->nullable();
            $table->bigInteger('item_5')->unsigned()->nullable();
            $table->timestamps();
        });


        Schema::table('recipes', function ($table) {
            $table->foreign('item_id')->references('id')->on('items');
        });
        Schema::table('recipes', function ($table) {
            $table->foreign('item_1')->references('id')->on('items');
        });
        Schema::table('recipes', function ($table) {
            $table->foreign('item_2')->references('id')->on('items');
        });
        Schema::table('recipes', function ($table) {
            $table->foreign('item_3')->references('id')->on('items');
        });
        Schema::table('recipes', function ($table) {
            $table->foreign('item_4')->references('id')->on('items');
        });
        Schema::table('recipes', function ($table) {
            $table->foreign('item_5')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}