<?php

use App\PhytoChemicalConstituentsReport;
use App\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePhytoChemicalConstituentsForAlc04025 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Find the product with code 'Alc/040/25'
        $product = Product::where('code', 'Alc/040/25')->first();

        if ($product) {
            // Check if record already exists
            $existing = PhytoChemicalConstituentsReport::where('product_id', $product->id)
                ->first();

            if (!$existing) {
                // Create new record
                DB::table('phyto_chemical_constituents_reports')->insert([
                    'product_id' => $product->id,
                    'phyto_testconducted_id' => 3,
                    'name' => 13,
                    'addedby_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Update existing record
                DB::table('phyto_chemical_constituents_reports')
                    ->where('id', $existing->id)
                    ->update([
                        'phyto_testconducted_id' => 3,
                        'name' => 13,
                        'addedby_id' => 4,
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Find the product with code 'Alc/040/25'
        $product = DB::table('products')->where('code', 'Alc/040/25')->first();

        if ($product) {
            // Delete the record created by this migration
            DB::table('phyto_chemical_constituents_reports')
                ->where('product_id', $product->id)
                ->where('phyto_testconducted_id', 3)
                ->where('name', 13)
                ->delete();
        }
    }
}
