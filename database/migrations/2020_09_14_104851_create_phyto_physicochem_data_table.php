<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhytoPhysicochemDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phyto_physicochem_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->nullable();
            $table->string('result', 128)->nullable();
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
        Schema::dropIfExists('phyto_physicochem_data');
    }
}
