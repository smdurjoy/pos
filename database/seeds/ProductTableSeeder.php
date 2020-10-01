<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id' => 1, 'supplier_id' => '1', 'unit_id' => '1', 'category_id' => '2', 'name' => 'Walton Mobile i70'],
            ['id' => 2, 'supplier_id' => '1', 'unit_id' => '1', 'category_id' => '2', 'name' => 'Walton Fan cc02'],
            ['id' => 3, 'supplier_id' => '1', 'unit_id' => '1', 'category_id' => '2', 'name' => 'Walton Television tv09'],
        ];

        Product::insert($productRecords);
    }
}
