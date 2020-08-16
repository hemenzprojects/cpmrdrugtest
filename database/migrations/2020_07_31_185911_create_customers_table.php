<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('img_url')->default('assets/img/users/user.png');
            $table->string('email')->nullable()->unique();
            $table->string('tell')->nullable();
            $table->string('street_address')->nullable();
            $table->string('house_number')->nullable();
            $table->integer('added_by_id')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::drop('customers');
    }
}
