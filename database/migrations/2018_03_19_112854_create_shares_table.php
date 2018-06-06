<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('restrict')->onUpdate('cascade');
            $table->float('amount');
            $table->date('date_received');
            $table->integer('received_by_id')->unsigned()->nullable();
            $table->string('received_by')->default('')->nullable();
            //$table->foreign('received_by_id')->references('id')->on('members')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('paid_by_id')->unsigned();
            $table->string('paid_by');
            $table->foreign('paid_by_id')->references('id')->on('members')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('shares');
    }
}
