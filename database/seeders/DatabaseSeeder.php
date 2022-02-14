<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('stations')->insert([
                [
                    'name' => 'АС Луцьк',
                    'kod' => 1,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС-2 Луцьк',
                    'kod' => 2,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Горохів',
                    'kod' => 3,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Любешів',
                    'kod' => 4,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Маневичі',
                    'kod' => 5,
                    'created_at' => now(),
                ],
                [
                    'name' => 'інші АС КАС Луцьк',
                    'kod' => 20,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Ковель',
                    'kod' => 21,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Камінь-Каширський',
                    'kod' => 22,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Ратне',
                    'kod' => 23,
                    'created_at' => now(),
                ],
                [
                    'name' => 'інші АС КАС Ковель',
                    'kod' => 40,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Володимир',
                    'kod' => 41,
                    'created_at' => now(),
                ],
                [
                    'name' => 'інші АС КАС Володимир',
                    'kod' => 60,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Нововолинськ',
                    'kod' => 50,
                    'created_at' => now(),
                ],
            ]
        );
    }
}
