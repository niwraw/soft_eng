<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinces;

class ProvinceController extends Controller
{
    public function getProvinces($regionCode)
    {
        $provinces = Provinces::where('region_code', $regionCode)->get();
        $options = '<option value="" disabled selected="true">Please select</option>';
        foreach ($provinces as $province) {
            $options .= '<option value="' . $province->province_code . '">' . $province->province_name . '</option>';
        }
        return $options;
    }
}
