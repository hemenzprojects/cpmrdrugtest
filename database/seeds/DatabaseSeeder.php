<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserTableSeeder::class);
        $this->call(AdminUserTypeTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(ProductTypeTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(DeptTypeTableSeeder::class);
        $this->call(DeptTableSeeder::class);
        $this->call(ProductDeptSeeder::class);
        $this->call(MicrobialLoadSeeder::class);
        $this->call(MicrobialEfficacySeeder::class);
        $this->call(PharmTestConductedSeeder::class);
        $this->call(PharmToxicitySeeder::class);
        $this->call(PhytoTestConductedSeeder::class);
        $this->call(PhytochemicalConstituentSeeder::class);
        $this->call(PhytoOrganolepticsSeeder::class);
        $this->call(PhytoPhytochemicalSeeder::class);
        $this->call(PharmStandardSeeder::class);
        $this->call(AnimalModelSeeder::class);
        $this->call(DeptOfficeTableSeeder::class);
        $this->call(AdminFeatureTableSeeder::class);
        $this->call(AdminFeatureTypeTableSeeder::class);




       














        
    }
}
