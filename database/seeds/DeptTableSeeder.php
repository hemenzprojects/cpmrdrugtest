<?php

use Illuminate\Database\Seeder;

class DeptTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->truncate();
        DB::table('departments')->insert([
            'name'   =>  'Microbiology',
            'dept_type_id'   =>  1,         
            'description'   =>  'This is the Microbiology department',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

         DB::table('departments')->insert([
            'name'   =>  'Pharmacology',
            'dept_type_id'   =>  1,         
            'description'   =>  'This is the Pharmacology department',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

         
        ]);
          DB::table('departments')->insert([
            'name'   =>  'Pytochemistry',
            'dept_type_id'   =>  1,         
            'description'   =>  'This is the Pytochemistry department',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('departments')->insert([
            'name'   =>  'SID',
            'dept_type_id'   =>  2,         
            'description'   =>  'This is the SID department',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
    }
}
