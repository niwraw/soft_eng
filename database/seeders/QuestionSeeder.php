<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            $questionId = DB::table('queries')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->email,
                'question' => $faker->sentence($nbWords = 10, $variableNbWords = true), 
            ]);

            DB::table('response')->insert([
                'query_id' => $questionId,
                'answer' => $faker->sentence(6, true),
            ]);
        }
    }
}
