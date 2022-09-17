<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    private $users = [
        [
            'name' => 'Иван',
            'patronymic' => 'Иванович',
            'last_name' => 'Иванов',
            'phone' => '+7 911 123 11 11',
            'email' => 'ivanov@mail.ru',
            'address' => 'г. Москва, ул. Марксистская, 4',
        ],
        [
            'name' => 'Семён',
            'patronymic' => 'Семёнович',
            'last_name' => 'Семёнов',
            'phone' => '+7 911 123 22 22',
            'email' => 'semenov@mail.ru',
            'address' => 'г. Москва, ул. Вавилова, 19',
        ],
        [
            'name' => 'Мария',
            'patronymic' => 'Петровна',
            'last_name' => 'Петрова',
            'phone' => '+7 911 123 33 33',
            'email' => 'petrova@mail.ru',
            'address' => 'г. Москва, ул. Наметкина, 16',
        ],
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
