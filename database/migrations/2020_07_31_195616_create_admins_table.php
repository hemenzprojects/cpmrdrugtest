<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('img_url')->default('assets/img/users/user.png');
            $table->string('sign_url')->nullable();
            $table->string('dept_id');
            $table->string('tell')->nullable();
            $table->string('street_address')->nullable();
            $table->string('house_number')->nullable();
            $table->integer('user_type_id');
            $table->integer('dept_office_id');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_type_id')
            ->references('id')->on('user_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('dept_id')
            ->references('id')->on('depts')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('dept_office_id')
            ->references('id')->on('dept_offices')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
    }
}
