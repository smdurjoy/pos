<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitRecords = [
            ['id' => 1, 'name' => 'Grocery'],
            ['id' => 2, 'name' => 'Electronics'],
            ['id' => 3, 'name' => 'Gadgets'],
        ];

        Category::insert($unitRecords);
    }
}
