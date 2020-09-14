<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmAnimalExperimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharm_animal_experiments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('pharm_testconducted_id');
            $table->integer('animal_model');
            $table->string('weight');
            $table->string('volume');
            $table->integer('death')->nullable();
            $table->integer('toxicity');
            $table->integer('sex');
            $table->integer('method');
            $table->integer('group');
            $table->string('period');
            $table->integer('total_days');
            $table->string('dosage')->nullable();

            $table->integer('added_by_id')->nullable();
            $table->timestamps();

            $table->foreign('pharm_testconducted_id')
            ->references('id')->on('pharm_test_conducteds')
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
        Schema::dropIfExists('pharm_animal_experiments');
    }
}
