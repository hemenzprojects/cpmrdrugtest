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
            'Position'=>'Head of department',
            'tell'=>'0245678909',
            'user_type_id' => 1,
            'dept_office_id' => 1,
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
            'Position'=>'Reseach Officer',
            'tell'=>'0303933828',
            'user_type_id' => 1,
            'dept_id' => 1,
            'dept_office_id' => 1,
            'email'   =>  'cpmruser1@gmail.com',
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        
        DB::table('admins')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Stephen',
            'last_name'   =>  'Akoto',
            'tell'=>'0245893929',
            'Position'=>'Reseach Officer',
            'user_type_id' => 2,
            'dept_office_id' => 1,
            'dept_id' => 2,
            'email'   =>  'cpmruser2@gmail.com',
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('admins')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Henry',
            'last_name'   =>  'Mensah',
            'Position'=>'Reseach Officer',
            'tell'=>'0245002838',
            'user_type_id' => 2,
            'dept_office_id' => 1,
            'dept_id' => 3,
            'email'   =>  'cpmruser3@gmail.com',
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('admins')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Guard',
            'last_name'   =>  'Dusor',
            'Position'=>'Reseach Officer',
            'tell'=>'0245728290',
            'user_type_id' => 2,
            'dept_office_id' => 1,
            'dept_id' => 4,
            'email'   =>  'cpmruser4@gmail.com',
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
