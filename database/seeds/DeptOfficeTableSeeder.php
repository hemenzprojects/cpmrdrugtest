<?php

use Illuminate\Database\Seeder;

class DeptOfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dept_offices')->truncate();

        DB::table('dept_offices')->insert([
          'name'   =>  'Department Head',
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);

      DB::table('dept_offices')->insert([
        'name'   =>  'Technicians',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
     ]);

     DB::table('dept_offices')->insert([
        'name'   =>  'Animal House',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);
    DB::table('dept_offices')->insert([
        'name'   =>  'Drug Analysis',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);

    }
}
