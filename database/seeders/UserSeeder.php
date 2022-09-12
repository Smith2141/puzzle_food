<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    private $users = [
        ['name' => 'Иван', 'last_name' => 'Иванов', 'phone' => '+7 911 123 11 11', 'email' => 'ivanov@mail.ru'],
        ['name' => 'Семён', 'last_name' => 'Семёнов', 'phone' => '+7 911 123 22 22', 'email' => 'semenov@mail.ru'],
        ['name' => 'Мария', 'last_name' => 'Петрова', 'phone' => '+7 911 123 33 33', 'email' => 'petrova@mail.ru'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert($this->users);
    }
}
