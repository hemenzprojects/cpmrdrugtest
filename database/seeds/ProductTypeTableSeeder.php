<?php

use Illuminate\Database\Seeder;

class ProductTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->truncate();

        DB::table('product_types')->insert([
          'Code'   =>  'Null',
          'name'   =>  'Not specified',
          'description'   =>  'To be specified',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
        DB::table('product_types')->insert([
          'Code'   =>  'DC',
          'name'   =>  'Decoction',
          'description'   =>  'This is Decoction',
          'form'=> 1,
          'state'=> 2,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);

         DB::table('product_types')->insert([
          'code'   =>  'ALC',
          'name'   =>  'Alcoholic Beverage',
          'description'   =>  'This is Alcoholic Beverage',
          'added_by_id'   =>  1,
          'form'=> 1,
          'state'=> 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
           DB::table('product_types')->insert([
          'code'   =>  'CP',
          'name'   =>  'Capsules',
          'description'   =>  'This is Capsules',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
           DB::table('product_types')->insert([
          'code'   =>  'PD',
          'name'   =>  'Powder',
          'description'   =>  'This is Powder',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
         DB::table('product_types')->insert([
          'code'   =>  'OT',
          'name'   =>  'Ointment',
          'description'   =>  'This is Ointment',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
         DB::table('product_types')->insert([
          'code'   =>  'CR',
          'name'   =>  'Cream',
          'description'   =>  'This is Cream',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
         DB::table('product_types')->insert([
          'code'   =>  'BA',
          'name'   =>  'Balm',
          'description'   =>  'This is Balm',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
      DB::table('product_types')->insert([
          'code'   =>  'HT',
          'name'   =>  'Herbal Tea',
          'description'   =>  'This is Herbal tea',
          'form'=> 2,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);

      DB::table('product_types')->insert([
          'code'   =>  'SPL',
          'name'   =>  'Soap (Liquid)',
          'description' =>  'This is Liquid soap',
          'form'=> 1,
          'state'=> 2,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);

      DB::table('product_types')->insert([
          'code'   =>  'SPS',
          'name'   =>  'Soap (Solid)',
          'description' =>  'This is solid soap',
          'form'=> 1,
          'state'=> 1,
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);
    }
}
