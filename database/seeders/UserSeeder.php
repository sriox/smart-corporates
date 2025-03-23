<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Sergio Rios',
            'email' => 'sergioriosg@gmail.coma',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
