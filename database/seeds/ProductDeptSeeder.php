<?php

use Illuminate\Database\Seeder;

class ProductDeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_depts')->truncate();

        DB::table('product_depts')->insert([
          
            'product_id' => 1,
            'dept_id' => 1,
            'status'   =>  1,
            'quantity' => 2,
            'distributed_by' => 1,
            'received_by' => 1,
            'delivered_by' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        
        DB::table('product_depts')->insert([
          
            'product_id' => 1,
            'dept_id' => 2,
            'status'   =>  1,
            'quantity' => 2,
            'distributed_by' => 1,
            'received_by' => 1,
            'delivered_by' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        
        DB::table('product_depts')->insert([
          
            'product_id' => 1,
            'dept_id' => 3,
            'status'   =>  1,
            'quantity' => 2,
            'distributed_by' => 1,
            'received_by' =>1,
            'delivered_by' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
