<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaculteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('facultes')->insert([
            ['title' => 'Faculty Of Sciences',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['title' => 'Faculty Of Letters',
             'created_at' => now(),
             'updated_at' => now(),
            ],
        ]);

        DB::table('users')->insert([
            'name' => 'Joker',
            'email' => 'admin@mail.com',
            'role_name' => 'Admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }
}
