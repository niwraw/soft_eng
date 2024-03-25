<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;

class CityController extends Controller
{
    public function getCities($provinceCode)
    {
        $cities = Cities::where('province_code', $provinceCode)->get();
        $options = '<option value="" disabled selected="true">Please select</option>';
        foreach ($cities as $city) {
            $options .= '<option value="' . $city->city_code . '">' . $city->city_name . '</option>';
        }
        return $options;
    }
}
