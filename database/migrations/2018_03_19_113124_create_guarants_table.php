<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuarantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->integer('loan_owner_id')->unsigned();
            $table->float('amount');
            $table->timestamps();
            $table->float('to_release')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('loan_id')->references('id')->on('loans')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('loan_owner_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('restrict');
            $table->float('retention_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guarants');
    }
}
