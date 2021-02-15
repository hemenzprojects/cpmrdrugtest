<?php

use Illuminate\Database\Seeder;

class AdminFeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_features')->truncate();

        DB::table('admin_features')->insert([
            'id'   => 1,
            'name'            => 'Read customer records',
            'description'     => 'View customer records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 2,
            'name'            => 'Write customer records',
            'description'     => 'Create/update customer records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 3,
            'name'            => 'Read product records',
            'description'     => 'View product records',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 4,
            'name'            => 'Write product records',
            'description'     => 'Edit product records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 5,
            'name'            => 'Read product type records',
            'description'     => 'View product type records',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 6,
            'name'            => 'Write product type records',
            'description'     => 'Edit product type records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 7,
            'name'            => 'Read product Review records',
            'description'     => 'View product Review records',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 8,
            'name'            => 'Write product Review records',
            'description'     => 'Edit product Review records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 9,
            'name'            => 'Read Account records',
            'description'     => 'View Account records',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 10,
            'name'            => 'Write Account records',
            'description'     => 'Edit Account records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 11,
            'name'            => 'Read product distribution',
            'description'     => 'View product distribution',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 12,
            'name'            => 'Write product distribution',
            'description'     => 'Edit product distribution',
            'added_by_id'  => 1,
        ]);
        
        DB::table('admin_features')->insert([
            'id'   => 13,
            'name'            => 'Read product delivery',
            'description'     => 'View devlivery records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 14,
            'name'            => 'Write product delivery',
            'description'     => 'Create, Update records on delivery products ',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 15,
            'name'            => 'Read report taskboard 1',
            'description'     => 'View Main Report Taskboard',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 16,
            'name'            => 'write report taskboard 1',
            'description'     => 'View More Report Taskboard',
            'added_by_id'  => 1,
        ]);
      
        DB::table('admin_features')->insert([
            'id'   => 17,
            'name'            => 'Read report taskboard 2',
            'description'     => 'Create, update, new report',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 18,
            'name'            => 'Write report taskboard 2',
            'description'     => 'Delete report',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 19,
            'name'            => 'Read Hod office',
            'description'     => 'View Hod office',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 20,
            'name'            => 'Write hod office',
            'description'     => 'Update, Approve records',
            'added_by_id'  => 1,
        ]);
        
        DB::table('admin_features')->insert([
            'id'   => 21,
            'name'            => 'Read HoD office annex',
            'description'     => 'View HoD office',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 22,
            'name'            => 'Write hod office annex',
            'description'     => 'complete records',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 23,
            'name'            => 'Read Hod office configuration',
            'description'     => 'View Hod office configuration',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 24,
            'name'            => 'Write Hod office configuration',
            'description'     => 'Create, Edit & delete Hod 0ffice configuration',
            'added_by_id'  => 1,
        ]);

        DB::table('admin_features')->insert([
            'id'   => 25,
            'name'            => 'Read record book',
            'description'     => 'View record book',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 26,
            'name'            => 'Write record book',
            'description'     => 'Update record book',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 27,
            'name'            => 'Read general Report',
            'description'     => 'View general Report',
            'added_by_id'  => 1,
        ]);
        DB::table('admin_features')->insert([
            'id'   => 28,
            'name'            => 'write general Report',
            'description'     => 'Read general Report Details',
            'added_by_id'  => 1,
        ]);
    }
}
