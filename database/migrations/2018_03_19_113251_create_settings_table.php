<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->float('share_value')->nullable();
            $table->integer('loan_duration')->nullable();
            $table->float('loan_interest')->nullable();
            $table->integer('loan_borrowable')->nullable();
            $table->integer('retention_fee')->nullable();
            $table->integer('min_guarantors')->default(1);
            $table->boolean('notifications')->default(false);
            $table->string('notification_number')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
