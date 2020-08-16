<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'michael',
            'last_name'   =>  'himeng',
            'tell'=>'0245678909',
            'user_type_id' => 1,
            'dept_id' => 1,
            'email'   =>  'hemenmike@gmail.com',
            'password' => Hash::make('mike123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('admins')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Paa',
            'last_name'   =>  'Kwasi',
            'tell'=>'0303933828',
            'user_type_id' => 1,
            'dept_id' => 1,
            'email'   =>  'paakwasi@gmail.com',
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        
        DB::table('admins')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Guard',
            'last_name'   =>  'Dusor',
            'tell'=>'0245839220',
            'user_type_id' => 2,
            'dept_id' => 4,
            'email'   =>  'guard@gmail.com',
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
