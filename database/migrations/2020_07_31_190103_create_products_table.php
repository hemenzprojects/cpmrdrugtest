<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('customer_id');
            $table->integer('product_type_id');
            $table->double('price');
            $table->double('quantity');
            $table->date('mfg_date');
            $table->date('exp_date');
            $table->string('company');
            $table->string('indication');

            $table->integer('overall_status')->default(1)->nullable();

            $table->text('micro_comment')->nullable();
            $table->text('micro_conclution')->nullable();
            $table->string('micro_dateanalysed')->nullable();
            $table->integer('micro_overall_status')->default(1)->nullable();
            $table->integer('micro_hod_evaluation')->default(1)->comment('1 - Approval pending 2 - Report Approved');
            $table->integer('micro_appoved_by')->nullable();
            $table->integer('micro_analysed_by')->nullable();

            $table->integer('pharm_testconducted')->nullable()->comment('1 - Determal Toxicity Test 2 - Acute Toxicity Test');
            $table->integer('pharm_overall_status')->default(1)->nullable();
            $table->integer('pharm_process_status')->default(1)->nullable()->comment('begins from (3-animal experiment)');
            $table->integer('pharm_hod_evaluation')->default(1)->comment('1 - Approval pending 2 - Report Approved');
            $table->text('pharm_comment')->nullable();
            $table->date('pharm_dateanalysed')->nullable();
            $table->date('pharm_datecompleted')->nullable();
            $table->integer('pharm_appoved_by')->nullable();
            $table->integer('pharm_analysed_by')->nullable();

            $table->text('phyto_comment')->nullable();
            $table->date('phyto_dateanalysed')->nullable();
            $table->integer('phyto_overall_status')->default(1)->nullable();
            $table->integer('phyto_hod_evaluation')->nullable()->comment('1 - Approval pending 2 - Report Approved');
            $table->integer('phyto_appoved_by')->nullable();
            $table->integer('phyto_analysed_by')->nullable();
       
            $table->integer('added_by_id')->nullable();

            $table->foreign('product_type_id')
                ->references('id')->on('product_types')
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
        Schema::dropIfExists('products');
    }
}
