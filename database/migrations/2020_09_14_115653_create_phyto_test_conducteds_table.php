<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhytoTestConductedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phyto_test_conducteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->nullable();
            $table->string('description', 128)->nullable();
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
        Schema::dropIfExists('phyto_test_conducteds');
    }
}
