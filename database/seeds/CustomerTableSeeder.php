<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerRecords = [
            ['id' => 1, 'name' => 'Saqlain Mustaq Durjoy', 'number' => '01784996428', 'Address' => 'Rangpur, Bangladesh'],
            ['id' => 2, 'name' => 'Sakibul Islam', 'number' => '01333335555', 'Address' => 'Savar, Dhaka'],
            ['id' => 3, 'name' => 'Mahmudul Hasan', 'number' => '01555554444', 'Address' => 'Uttara sector 10, Dhaka'],
            ['id' => 4, 'name' => 'Jason Roy', 'number' => '01888883333', 'Address' => 'London, England'],
            ['id' => 5, 'name' => 'Mahmudullah Riyad', 'number' => '01666662222', 'Address' => 'Mohammadpur, Dhaka'],
        ];

        Customer::insert($customerRecords);
    }
}
