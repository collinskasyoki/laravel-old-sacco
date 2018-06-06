<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('loan_id')->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('paid_by_id')->unsigned();
            $table->foreign('paid_by_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('restrict');
            $table->string('paid_by')->default('');
            $table->float('amount');
            $table->date('received_date');
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
        Schema::dropIfExists('payments');
    }
}
