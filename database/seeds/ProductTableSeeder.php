<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('products')->truncate();
        DB::table('products')->insert([
            'name'   =>  'Dx herbal mixture',
            'customer_id'   =>  3,
            'product_type_id' => 2,
            'added_by_id' => 1,
            'price' => 460,
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'company' => 'Lucas Herbal',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_dateanalysed' => 'some dateanalysed text',
            'micro_overall_status' => 'passed',
            'micro_hod_evaluation' => 1,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);

          DB::table('products')->insert([
            'name'   =>  'milicas capsules',
            'customer_id'   =>  2,
            'product_type_id' => 3,
            'added_by_id' => 1,
            'price' => 460,
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'company' => 'Madingo Limited',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_dateanalysed' => 'some dateanalysed text',
            'micro_overall_status' => 'failed',
            'micro_hod_evaluation' => 2,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);

        DB::table('products')->insert([
            'name'   =>  'Manamaco Tablet',
            'customer_id'   =>  3,
            'product_type_id' => 3,
            'added_by_id' => 1,
            'price' => 460,
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'company' => 'Monarch Pharma',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_dateanalysed' => 'some dateanalysed text',
            'micro_overall_status' => 'passed',
            'micro_hod_evaluation' => 1,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);

        DB::table('products')->insert([
            'name'   =>  'Alomo',
            'customer_id'   =>  1,
            'product_type_id' => 4,
            'added_by_id' => 1,
            'price' => 460,
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'company' => 'Damacare Centre',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_dateanalysed' => 'some dateanalysed text',
            'micro_overall_status' => 'failed',
            'micro_hod_evaluation' => 2,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);
    }
}
