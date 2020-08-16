<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->truncate();

        DB::table('customers')->insert([
            'title'   =>  'Mrs',
            'first_name'   =>  'Eunice',
            'last_name'   =>  'Opong',
            'tell'=>'0245678909',
            'email'   =>  'euniceopong@gmail.com',
            'street_address'   =>  'Malex Limited',
            'house_number'   =>  'HB 123',
            'added_by_id'   =>  1,
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('customers')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Alex',
            'last_name'   =>  'Offosu',
            'tell'=>'0245678909',
            'email'   =>  'alexoffosug@gmail.com',
            'street_address'   =>  'Hamadia Mck',
            'house_number'   =>  'ABSC 23919',
            'added_by_id'   =>  1,
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('customers')->insert([
            'title'   =>  'Mr',
            'first_name'   =>  'Francis',
            'last_name'   =>  'Afari',
            'tell'=>'0234838282',
            'email'   =>  'francisaffarig@gmail.com',
            'street_address'   =>  'Aland 124',
            'house_number'   =>  'AB 23919',
            'added_by_id'   =>  1,
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
