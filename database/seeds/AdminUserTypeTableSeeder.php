<?php

use Illuminate\Database\Seeder;

class AdminUserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->truncate();

        DB::table('user_types')->insert([
          'name'   =>  'Head of Department',
          'added_by_id'   =>  1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
      ]);

      DB::table('user_types')->insert([
        'name'   =>  'Assistant Head',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
     ]);

     DB::table('user_types')->insert([
        'name'   =>  'Lab Technician ',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);
    DB::table('user_types')->insert([
        'name'   =>  'Assistant Lab Technologist ',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);

    DB::table('user_types')->insert([
        'name'   =>  'Administrator',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);

    DB::table('user_types')->insert([
        'name'   =>  'Assistant Administrator',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);

    
    DB::table('user_types')->insert([
        'name'   =>  'System Administrator',
        'added_by_id'   =>  1,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);
    }
}
