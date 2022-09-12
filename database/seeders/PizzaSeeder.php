<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pizzas')->insert(
            [
                ['name' => 'Cheesy joy', 'amount' => 1500],
                ['name' => 'Roman Holidays', 'amount' => 2000],
                ['name' => 'Paradise Island', 'amount' => 3500],
            ]
        );
    }
}
