<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function cities($region_id) {
        $cities = DB::table('cities')->where('region_id',$region_id)->get();
        return json_encode($cities);
    }
}
