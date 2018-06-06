<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifyLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->dateTime('send_timestamp');
          $table->integer('messagestatus');
          $table->string('messageto');
          $table->string('message');
          $table->string('messageid');
          $table->integer('member_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify_logs');
    }
}
