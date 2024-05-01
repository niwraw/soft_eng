<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            DB::table('announcements')->insertGetId([
                'date' => $faker->date,
                'announcement' => $faker->sentence($nbWords = 10, $variableNbWords = true), 
            ]);
        }

        DB::table('important_dates')->insert([
            'status' => "start",
            'date' => "2024-01-01",
        ]);

        DB::table('important_dates')->insert([
            'status' => "end",
            'date' => "2024-01-31",
        ]);
    }
}
