<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitRecords = [
            ['id' => 1, 'name' => 'PCS'],
            ['id' => 2, 'name' => 'KG'],
        ];

        Unit::insert($unitRecords);
    }
}
