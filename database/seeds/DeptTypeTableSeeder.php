<?php

use Illuminate\Database\Seeder;

class DeptTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dept_types')->truncate();
        DB::table('dept_types')->insert([
            'name'   =>  'Research lab',
            'description'   =>  'This is for lab purposes',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

         DB::table('dept_types')->insert([
            'name'   =>  'administration',
            'description'   =>  'This administrative/office purposes',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

         
        ]);
    }
}
