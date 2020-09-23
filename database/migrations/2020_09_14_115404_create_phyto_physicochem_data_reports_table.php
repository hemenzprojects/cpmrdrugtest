<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhytoPhysicochemDataReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phyto_physicochem_data_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->nullable();
            $table->integer('phyto_testconducted_id')->nullable();
            $table->integer('phyto_physicochemdata_id')->nullable();
            $table->string('name', 32)->nullable();
            $table->string('result', 32)->nullable();
            $table->integer('addedby_id')->nullable();

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
        Schema::dropIfExists('phyto_physicochem_data_reports');
    }
}
