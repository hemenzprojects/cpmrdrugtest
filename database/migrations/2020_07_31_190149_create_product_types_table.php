<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 32);
            $table->string('name', 32);
            $table->integer('form')->comment('cold or Hot Method');
            $table->integer('state')->comment('Solid or Liquid');
            $table->integer('method_applied')->comment('Skin or aural');
            $table->integer('pharm_standard_id')->nullable()->comment('This contains default standard for a particular product type');
            $table->text('description')->nullable();
            $table->integer('added_by_id')->nullable();
        
            $table->foreign('pharm_standard_id')
                ->references('id')->on('pharm_standards')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('product_types');
    }
}
