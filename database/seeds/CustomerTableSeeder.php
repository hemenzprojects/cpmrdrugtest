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
            'company_name'   =>  'Amakania Ltd',
            'company_address'   =>  'Malex Limited',
            'company_phone'   =>  '0245670292',
            'company_location'   =>  'ABSC 23919',
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
            'company_name'   =>  'Helmatic Herbal',
            'company_address'   =>  'Hamadia Mck',
            'company_phone'   =>  '0245667872',
            'company_location'   =>  'AWEC F450',
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
            'company_name'   =>  'Philapino Official',
            'company_address'   =>  'Ramatamin LMT',
            'company_phone'   =>  '0246878999',
            'company_location'   =>  'AWC JUNCTION',
            'added_by_id'   =>  1,
            'password' => Hash::make('123456'),
            'img_url' => 'assets/img/users/1.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
