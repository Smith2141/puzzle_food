<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert(
            [
                ['user_id' => 1, 'is_paid' => 1, 'is_cooked' => 1, 'is_delivered' => 1],
                ['user_id' => 2, 'is_paid' => 1, 'is_cooked' => 1, 'is_delivered' => 0],
                ['user_id' => 2, 'is_paid' => 1, 'is_cooked' => 0, 'is_delivered' => 0],
            ]
        );
    }
}
