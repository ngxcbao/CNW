<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            DB::table('sales')->insert([
                [
                    'medicine_id' => 1, // Tham chiếu đến `medicines.id`
                    'quantity' => 2,
                    'sale_date' => Carbon::now(),
                    'customer_phone' => '0987654321',
                ],
                [
                    'medicine_id' => 2,
                    'quantity' => 1,
                    'sale_date' => Carbon::now(),
                    'customer_phone' => '0976543210',
                ],
                [
                    'medicine_id' => 3,
                    'quantity' => 3,
                    'sale_date' => Carbon::now(),
                    'customer_phone' => '0965432109',
                ],
            ]);
}
    }
}