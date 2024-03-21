<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RegionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $region = File::get(database_path('data/region.json'));
        $data = json_decode($region);

        foreach ($data as $obj) {
            DB::table('app_form_region')->insert([
                'region_code' => $obj->region_code,
                'region_name' => $obj->region_name,
            ]);
        }

        $region = File::get(database_path('data/province.json'));
        $data = json_decode($region);

        foreach ($data as $obj) {
            DB::table('app_form_province')->insert([
                'province_code' => $obj->province_code,
                'province_name' => $obj->province_name,
                'region_code' => $obj->region_code,
            ]);
        }

        $region = File::get(database_path('data/city.json'));
        $data = json_decode($region);

        foreach ($data as $obj) {
            DB::table('app_form_city')->insert([
                'city_code' => $obj->city_code,
                'city_name' => $obj->city_name,
                'province_code' => $obj->province_code,
            ]);
        }

        $region = File::get(database_path('data/barangay.json'));
        $data = json_decode($region);

        foreach ($data as $obj) {
            DB::table('app_form_barangay')->insert([
                'brgy_code' => $obj->brgy_code,
                'brgy_name' => $obj->brgy_name,
                'city_code' => $obj->city_code,
            ]);
        }
    }
}
