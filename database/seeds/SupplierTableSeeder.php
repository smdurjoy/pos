<?php

use Illuminate\Database\Seeder;
use App\Supplier;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplierRecords = [
            ['id' => 1, 'name' => 'Walton Industries Limited', 'number' => '01999996666', 'Address' => 'Mirpur, Dhaka'],
            ['id' => 2, 'name' => 'PRAN-RFL GROUP', 'number' => '01333335555', 'Address' => 'Savar, Dhaka'],
            ['id' => 3, 'name' => 'Bashundhara group.', 'number' => '01555554444', 'Address' => 'Uttara sector 10, Dhaka'],
            ['id' => 4, 'name' => 'Navana group.', 'number' => '01888883333', 'Address' => 'Mohammadpur, Dhaka'],
            ['id' => 5, 'name' => 'Beximco group.', 'number' => '01666662222', 'Address' => 'Mohammadpur, Dhaka'],
        ];

        Supplier::insert($supplierRecords);
    }
}
