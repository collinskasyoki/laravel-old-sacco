<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer     ('member_id')->unsigned();
            $table->string      ('owner')->nullable();
            $table->foreign     ('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('restrict');
            $table->float       ('amount');
            $table->date        ('date_due');
            $table->float       ('amount_payable');
            $table->boolean     ('approved');
            $table->date        ('date_given');
            $table->boolean     ('paid_full');
            $table->boolean     ('defaulted')->default(0);
            $table->integer     ('flag')->default(0);
            $table->string      ('guarantors_csv');
            $table->boolean     ('warned')->default(false);
            $table->float       ('retention_fee')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
