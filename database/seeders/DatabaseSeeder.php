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
                    'name' => 'АС Ковель',
                    'kod' => 2,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Володимир',
                    'kod' => 3,
                    'created_at' => now(),
                ],
                [
                    'name' => 'АС Нововолинськ',
                    'kod' => 4,
                    'created_at' => now(),
                ],
            ]
        );
    }
}
