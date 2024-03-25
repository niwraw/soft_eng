<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangays;

class BarangayController extends Controller
{
    public function getBarangays($cityCode)
    {
        $barangays = Barangays::where('city_code', $cityCode)->get();
        $options = '<option value="" disabled selected="true">Please select</option>';
        foreach ($barangays as $barangay) {
            $options .= '<option value="' . $barangay->brgy_code . '">' . $barangay->brgy_name . '</option>';
        }
        return $options;
    }
}
