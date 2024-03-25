<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SchoolSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = File::get(database_path('data/schools.json'));
        $data = json_decode($schools);

        foreach ($data as $obj) {
            DB::table('app_form_school')->insert([
                'school_id' => $obj->school_id,
                'school_name' => $obj->school_name,
            ]);
        }
    }
}
