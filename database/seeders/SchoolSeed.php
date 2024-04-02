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
        $region = File::get(database_path('data/region.json'));
        $province = File::get(database_path('data/province.json'));
        $municipality = File::get(database_path('data/city.json'));
        $region = json_decode($region);
        $province = json_decode($province);
        $municipality = json_decode($municipality);
        $data = json_decode($schools);



        foreach ($data as $obj) {
            $regions = null;
            $provinces = null;
            $municipalities = null;
            $temp = null;

            foreach ($region as $reg) {
                $name = null;

                if ($obj->region == "Region IV-B")
                {
                    $name = "MIMAROPA";
                }
                else if ($obj->region == "NIR")
                {
                    if($obj->province == "Negros Occidental")
                    {
                        $name = "Region VI";
                    }
                    else if ($obj->province == "Negros Oriental")
                    {
                        $name = "Region VII";
                    }
                }
                else 
                {
                    $name = $obj->region;
                }

                if (strpos(strtolower($reg->region_name), strtolower($name)) !== false) {
                    $regions = $reg->region_name;
                    break;
                }
            }

            foreach ($municipality as $mun) {
                $keyword = $obj->municipality;
                $keyword = trim(str_replace("ñ", "n", $keyword));
                $keyword = trim(str_replace("Ñ", "n", $keyword));
                $keyword = strtolower($keyword);
                $keyword = trim(str_replace("city", "", $keyword));
                $keyword = trim(str_replace("(capital)", "", $keyword));
                $keyword = trim(str_replace("(dadiangas)", "", $keyword));
                $keyword = trim($keyword);

                $find = $mun->city_name;
                $find = trim(str_replace("ñ", "n", $find));
                $find = trim(str_replace("Ñ", "n", $find));
                $find = strtolower($find);
                $find = trim(str_replace("city", "", $find));

                if (strpos(strtolower($find), strtolower($keyword)) !== false) {
                    $municipalities = $mun->city_name;
                    $temp = $mun->province_code;
                    break;
                }
            }

            foreach ($province as $prov) {
                if ($temp == $prov->province_code) {
                    $provinces = $prov->province_name;
                    break;
                }
            }

            DB::table('app_form_school')->insert([
                'school_id' => $obj->school_id,
                'school_name' => $obj->school_name,
                'region' => $regions,
                'province' => $provinces,
                'city' => $municipalities,
            ]);
        }
    }
}
