<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderPizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_pizza')->insert(
            [
                ['order_id' => 1, 'pizza_id' => 1],
                ['order_id' => 2, 'pizza_id' => 1],
                ['order_id' => 2, 'pizza_id' => 2],
                ['order_id' => 3, 'pizza_id' => 3],
                ['order_id' => 3, 'pizza_id' => 3],
            ]
        );
    }
}
