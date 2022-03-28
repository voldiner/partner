<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * role =>  1 - бухгалтер
     *          2 - перевезення
     * @return void
     */
    public function run()
    {
        DB::table('administrators')->insert([
                [
                    'name' => 'Сліпчук Оксана Олександрівна',
                    'email' => 'pratvopas@ukr.net',
                    'password' => bcrypt('Linden1635'),
                    'role' => 1,
                    'created_at' => now(),
                ],
                [
                    'name' => 'Боярська Наталія Вікторівна',
                    'email' => 'natasha1370@i.ua',
                    'password' => bcrypt('Alder8512'),
                    'role' => 1,
                    'created_at' => now(),
                ],
                [
                    'name' => 'Волдинер Юрій Арнольдович',
                    'email' => 'vold@vopas.com.ua',
                    'password' => bcrypt('123456'),
                    'role' => 1,
                    'created_at' => now(),
                ],
                [
                    'name' => 'Бондарчук Лариса Олексіївна',
                    'email' => 'vpim1@ukr.net',
                    'password' => bcrypt('Cooper4512'),
                    'role' => 1,
                    'created_at' => now(),
                ],

            ]
        );
    }
}
