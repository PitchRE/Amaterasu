<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('discord_id');
            $table->text('nickname')->nullable();
            $table->bigInteger('guild_id');
            $table->text('guild_name');
            $table->bigInteger('channel_id');
            $table->text('channel_name');
            $table->text('content');
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
        Schema::dropIfExists('messages_logs');
    }
}