<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('discord_id');
            $table->integer('luck')->default(0);
            $table->integer('luck_price')->default(500);
            $table->timestamps();
        });

        Schema::table('user_skills', function ($table) {
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
        Schema::dropIfExists('user_skills');
    }
}