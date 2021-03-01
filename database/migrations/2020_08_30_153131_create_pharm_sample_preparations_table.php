<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmSamplePreparationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharm_sample_preparations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('pharm_testconducted_id');

            $table->string('weight')->nullable();
            $table->string('dosage')->nullable();
            $table->string('yield')->nullable();
            $table->text('remarks')->nullable();

            $table->string('measurement')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('distributed_by')->nullable();
            $table->integer('received_by')->nullable();
            $table->integer('delivered_by')->nullable();

            $table->date('delivered_at')->nullable();
            $table->date('received_at')->nullable();
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
        Schema::dropIfExists('pharm_sample_preparations');
    }
}
