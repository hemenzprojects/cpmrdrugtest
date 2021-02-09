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
            $table->string('receipt_num');
            $table->integer('account_status')->default(1)->comment('1 - First payment 2 - Other payments');
            $table->double('quantity');
            $table->date('mfg_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->text('dosage');
            $table->text('indication');

            $table->integer('overall_status')->default(0)->nullable();

            $table->integer('micro_grade')->nullable()->comment('1 -Failed 2 - Passed');
            $table->integer('pharm_grade')->nullable()->comment('1 -Failed 2 - Passed');
            $table->integer('phyto_grade')->nullable()->comment('1 -Failed 2 - Passed');

            $table->text('micro_comment')->nullable();
            $table->text('micro_conclution')->nullable();
            $table->integer('micro_la_conclution')->nullable();
            $table->integer('micro_ea_conclution')->nullable();
            $table->date('micro_dateanalysed')->nullable();
            $table->date('micro_datecompleted')->nullable();
            $table->integer('micro_overall_status')->default(1)->nullable();
            $table->integer('micro_hod_evaluation')->nullable()->comment('1 - Approval pending 2 - Report Approved');
            $table->text('micro_hod_remarks')->nullable();
            $table->integer('micro_appoved_by')->nullable();
            $table->integer('micro_analysed_by')->nullable();
            $table->integer('micro_reference')->nullable();

            $table->integer('pharm_testconducted')->nullable()->comment('1 - Determal Toxicity Test 2 - Acute Toxicity Test');
            $table->integer('pharm_overall_status')->default(1)->nullable();
            $table->integer('pharm_process_status')->default(1)->nullable()->comment('begins from (3-animal experiment)');
            $table->integer('pharm_hod_evaluation')->nullable()->comment('1 - Approval pending 2 - Report Approved');
            $table->text('pharm_hod_remarks')->nullable();
            $table->text('pharm_result')->nullable();
            $table->text('pharm_comment')->nullable();
            $table->text('pharm_standard')->nullable();
            $table->date('pharm_dateanalysed')->nullable();
            $table->date('pharm_datecompleted')->nullable();
            $table->integer('pharm_appoved_by')->nullable();
            $table->integer('pharm_analysed_by')->nullable();
            $table->integer('pharm_experiment_by')->nullable();

            $table->text('phyto_comment')->nullable();
            $table->date('phyto_dateanalysed')->nullable();
            $table->date('phyto_datecompleted')->nullable();
            $table->integer('phyto_overall_status')->default(1)->nullable();
            $table->integer('phyto_hod_evaluation')->default(0)->nullable()->comment('1 - Approval pending 2 - Report Approved');
            $table->text('phyto_hod_remarks')->nullable();
            $table->integer('phyto_appoved_by')->nullable();
            $table->integer('phyto_analysed_by')->nullable();

            $table->string('failed_tag')->nullable();
       
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
