<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'name' => 'Bogotá',
            'slug' => 'bogota',
            'code' => 'BOG',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cities')->insert([
            'name' => 'Medellín',
            'slug' => 'medellin',
            'code' => 'MED',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cities')->insert([
            'name' => 'Cali',
            'slug' => 'cali',
            'code' => 'CAL',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
