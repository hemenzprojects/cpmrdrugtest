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
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);
    }
}
