<?php

use Illuminate\Database\Seeder;
use App\ProductType;
use App\Product;


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

        $type = ProductType::find(2);        
        DB::table('products')->insert([
            'name'   =>  'Dx herbal mixture',
            'code' => Product::generateCode($type),
            'customer_id'   =>  3,
            'product_type_id' => $type->id,
            'added_by_id' => 1,
            'price' => 460,
            'receipt_num' => 'IN3454',
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'dosage' => '2 times daily',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_overall_status' => 1,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);

        $type = ProductType::find(3);          
        DB::table('products')->insert([
            'name'   =>  'milicas capsules',
            'code' => Product::generateCode($type),
            'customer_id'   =>  2,
            'product_type_id' => $type->id,
            'added_by_id' => 1,
            'price' => 460,
            'receipt_num' => 'IN3455',
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'dosage' => '3 times daily',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_overall_status' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);

        $type = ProductType::find(3);        
        DB::table('products')->insert([
            'name'   =>  'Manamaco Tablet',
            'code' => Product::generateCode($type),
            'customer_id'   =>  3,
            'product_type_id' => $type->id,
            'added_by_id' => 1,
            'price' => 460,
            'receipt_num' => 'IN3456',
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'dosage' => '2 times daily',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_overall_status' => 1,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);

        $type = ProductType::find(7);        
        DB::table('products')->insert([
            'name'   =>  'Mercy Cream',
            'code' => Product::generateCode($type),
            'customer_id'   =>  1,
            'product_type_id' => $type->id,
            'added_by_id' => 1,
            'price' => 460,
            'receipt_num' => 'IN3457',
            'quantity' => 10,
            'mfg_date' => '2019-05-01',
            'exp_date' => '2020-06-07',
            'dosage' => '2 times daily',
            'indication' => 'antibacteria',
            'micro_comment' => 'somecomment text',
            'micro_conclution' => 'some conclution text',
            'micro_overall_status' => 1,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),

        ]);
    }
}
