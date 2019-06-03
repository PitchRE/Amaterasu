<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReputationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reputations', function (Blueprint $table) {
            $table->bigInteger('discord_id')->unique();
            $table->integer('points')->default(0);
            $table->timestamps();
        });

        Schema::table('reputations', function ($table) {
            $table->foreign('discord_id')->references('discord_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reputations');
    }
}