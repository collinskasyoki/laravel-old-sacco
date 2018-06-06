<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('id_no')->unique();
            $table->string('phone');
            $table->string('next_kin_name')->nullable();
            $table->string('next_kin_phone')->nullable();
            $table->integer('next_kin_id')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('pic')->default('');
            $table->string('speciality')->default('');
            $table->float('shares')->nullable();
            $table->date('registered_date')->nullable();
            $table->float('registration_fee')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_member')->default(0);
            $table->boolean('is_defector')->default(0);
            $table->integer('member_level')->nullable();
            $table->float('shares_held')->nullable();
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
        Schema::dropIfExists('members');
    }
}
