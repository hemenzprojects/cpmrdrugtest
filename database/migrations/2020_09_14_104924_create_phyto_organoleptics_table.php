<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhytoOrganolepticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phyto_organoleptics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->nullable();
            $table->string('feature', 128)->nullable();
            $table->integer('action')->default(0)->comment('this is to hide/show featuer');
            $table->integer('added_by_id')->nullable();
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
        Schema::dropIfExists('phyto_organoleptics');
    }
}
